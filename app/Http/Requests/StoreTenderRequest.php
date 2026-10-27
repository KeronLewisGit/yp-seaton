<?php

namespace App\Http\Requests;

use App\Enums\ProcurementMethod;
use App\Models\Tender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreTenderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    #[\Override]
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower(input_string($this->input('email'))),
            'bid_security' => $this->boolean('bid_security'),
        ]);
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'sector' => ['required', Rule::in(array_keys(Tender::SECTORS))],
            'entity_name' => ['required', 'string', 'max:160'],
            'contact_name' => ['required', 'string', 'max:120'],
            'contact_role' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^(?:\D*\d){7,15}\D*$/'],
            'title' => ['required', 'string', 'max:200'],
            'their_reference' => ['nullable', 'string', 'max:80'],
            'method' => ['required', Rule::enum(ProcurementMethod::class)],
            'parish' => ['nullable', Rule::in((array) yps('parishes'))],
            'location' => ['nullable', 'string', 'max:160'],
            'scope' => ['required', 'string', 'max:5000'],
            'estimated_value' => ['nullable', 'string', 'max:80'],
            'due_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'due_time' => ['required', 'date_format:H:i'],
            'clarification_due_on' => ['nullable', 'date_format:Y-m-d', 'before_or_equal:due_date'],
            'site_visit_date' => ['nullable', 'date_format:Y-m-d', 'before_or_equal:due_date'],
            'site_visit_time' => ['nullable', 'date_format:H:i'],
            'bid_security' => ['boolean'],
            'documents_url' => ['nullable', 'url:https,http', 'max:300'],
            'files' => ['nullable', 'array', 'max:'.Tender::MAX_FILES],
            'files.*' => ['file', 'max:10240', 'mimes:'.implode(',', Tender::FILE_TYPES)],
            'message' => ['nullable', 'string', 'max:3000'],
        ];
    }

    /** @return list<\Closure(Validator): void> */
    public function after(): array
    {
        return [function (Validator $v): void {
            if ($v->errors()->hasAny(['due_date', 'due_time'])) {
                return;
            }
            if ($this->dueAt()->isPast()) {
                $v->errors()->add('due_time', 'The submission deadline has already passed.');
            }
        }];
    }

    public function dueAt(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i', input_string($this->input('due_date')).' '.input_string($this->input('due_time')), config('app.timezone')) ?: now();
    }

    public function siteVisitAt(): ?Carbon
    {
        $date = input_string($this->input('site_visit_date'));
        if ($date === '') {
            return null;
        }

        return Carbon::createFromFormat('Y-m-d H:i', $date.' '.(input_string($this->input('site_visit_time')) ?: '10:00'), config('app.timezone')) ?: null;
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'entity_name' => 'procuring entity',
            'contact_name' => 'contact name',
            'title' => 'tender title',
            'method' => 'procurement method',
            'scope' => 'scope of works',
            'due_date' => 'submission date',
            'due_time' => 'submission time',
            'clarification_due_on' => 'clarification deadline',
            'site_visit_date' => 'site visit date',
            'documents_url' => 'link to the tender documents',
            'files.*' => 'tender document',
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Enter a phone number with its area code, for example (876) 555-0123.',
            'files.max' => 'Attach up to '.Tender::MAX_FILES.' files, or send a link to the documents instead.',
            'files.*.max' => 'Each tender document must be 10 MB or smaller. For larger sets, paste a link instead.',
            'files.*.mimes' => 'Tender documents can be PDF, Word, Excel or ZIP files.',
            'files.*.uploaded' => 'A tender document could not be uploaded. Files must be 10 MB or smaller.',
            'due_date.after_or_equal' => 'The submission date cannot be in the past.',
            'sector.required' => 'Choose whether this is a public-sector or private tender.',
            'method.required' => 'Choose the procurement method.',
        ];
    }
}
