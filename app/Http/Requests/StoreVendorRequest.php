<?php

namespace App\Http\Requests;

use App\Enums\DocumentKind;
use App\Enums\VendorType;
use App\Http\Requests\Concerns\HoldsUploads;
use App\Models\Vendor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVendorRequest extends FormRequest
{
    use HoldsUploads;

    public static function heldForm(): string
    {
        return 'prequal';
    }

    protected function heldFields(): array
    {
        return collect(DocumentKind::cases())->mapWithKeys(fn (DocumentKind $k) => ['docs.'.$k->value.'.file' => false])->all();
    }

    public function authorize(): bool
    {
        return true;
    }

    #[\Override]
    protected function prepareForValidation(): void
    {
        $this->restoreHeldUploads();
        $this->merge([
            'email' => strtolower(input_string($this->input('email'))),
            // TRNs are written 123-456-789 or 123 456 789; keep the digits.
            'trn' => preg_replace('/\D+/', '', input_string($this->input('trn'))),
        ]);
    }

    public function vendorType(): ?VendorType
    {
        return VendorType::tryFrom(input_string($this->input('type')));
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        $required = $this->vendorType()?->requiredDocuments() ?? DocumentKind::certificates();
        $rules = [
            'type' => ['required', Rule::enum(VendorType::class)],
            'company_name' => ['required', 'string', 'max:160'],
            'trading_as' => ['nullable', 'string', 'max:160'],
            'trn' => ['required', 'digits:9'],
            'company_number' => ['nullable', 'string', 'max:40'],
            'year_established' => ['nullable', 'integer', 'min:1900', 'max:'.now()->year],
            'address' => ['required', 'string', 'max:240'],
            'parish' => ['required', Rule::in((array) yps('parishes'))],
            'contact_name' => ['required', 'string', 'max:120'],
            'contact_role' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^(?:\D*\d){7,15}\D*$/'],
            'trades' => ['required', 'array', 'min:1', 'max:12'],
            'trades.*' => [Rule::in(array_keys((array) yps('trades')))],
            'parishes_served' => ['nullable', 'array'],
            'parishes_served.*' => [Rule::in((array) yps('parishes'))],
            'employees' => ['nullable', Rule::in(array_keys(Vendor::EMPLOYEE_BANDS))],
            'registration_grade' => ['nullable', 'string', 'max:120'],
            'experience' => ['nullable', 'string', 'max:3000'],
            'message' => ['nullable', 'string', 'max:2000'],
            'consent' => ['accepted'],
        ];
        foreach (DocumentKind::cases() as $kind) {
            $must = in_array($kind, $required, true);
            $k = 'docs.'.$kind->value;
            $rules[$k.'.file'] = [$must ? 'required' : 'nullable', 'file', 'max:5120', 'mimes:'.implode(',', Vendor::FILE_TYPES)];
            $rules[$k.'.number'] = ['nullable', 'string', 'max:80'];
            $rules[$k.'.expires_on'] = $kind->expires()
                ? [$must ? 'required' : 'nullable', 'required_with:'.$k.'.file', 'date_format:Y-m-d', 'after:today']
                : ['nullable', 'date_format:Y-m-d'];
        }

        return $rules;
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        $attrs = [
            'company_name' => 'company name',
            'trn' => 'TRN',
            'contact_name' => 'contact name',
            'year_established' => 'year established',
            'trades' => 'trade or supply category',
        ];
        foreach (DocumentKind::cases() as $kind) {
            $attrs['docs.'.$kind->value.'.file'] = $kind->label();
            $attrs['docs.'.$kind->value.'.expires_on'] = $kind->short().' expiry date';
        }

        return $attrs;
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        $messages = [
            'trn.digits' => 'A TRN has 9 digits, for example 123-456-789.',
            'phone.regex' => 'Enter a phone number with its area code, for example (876) 555-0123.',
            'trades.required' => 'Choose at least one trade or supply category.',
            'consent.accepted' => 'Please confirm the declaration to send your application.',
        ];
        foreach (DocumentKind::cases() as $kind) {
            $k = 'docs.'.$kind->value;
            $messages[$k.'.file.required'] = 'Upload your '.$kind->label().'.';
            $messages[$k.'.file.max'] = 'The '.$kind->short().' file must be 5 MB or smaller.';
            $messages[$k.'.file.mimes'] = 'The '.$kind->short().' must be a PDF, JPG or PNG.';
            $messages[$k.'.file.uploaded'] = 'The '.$kind->short().' could not be uploaded. Files must be 5 MB or smaller.';
            $messages[$k.'.expires_on.after'] = 'This '.$kind->short().' has expired. Upload the current certificate.';
            $messages[$k.'.expires_on.required'] = 'Enter the date the '.$kind->short().' expires.';
            $messages[$k.'.expires_on.required_with'] = 'Enter the date the '.$kind->short().' expires.';
        }

        return $messages;
    }
}
