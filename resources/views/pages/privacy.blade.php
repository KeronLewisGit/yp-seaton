<x-layouts.site title="Privacy notice" description="How Y.P. Seaton & Associates handles the details sent through this website.">
    <x-page-header photo="river-revetment" title="Privacy notice" kicker="Privacy" sheet="L-01" lead="What we keep when you send a tender, a prequalification, a job application or a message, and why." />
    <section class="wrap prose-copy measure mt-12 md:mt-16">
        <p>This website is run by {{ yps('name') }}, {{ yps('address.street') }}, {{ yps('address.city') }}, {{ yps('address.country') }}. It is written with the Data Protection Act, 2020 (Jamaica) in mind. Questions: <a href="mailto:{{ yps('email') }}">{{ yps('email') }}</a> or {{ format_phone(yps('phone')) }}.</p>
        <h2>What we collect</h2>
        <ul>
            <li><strong>Tender invitations:</strong> the procuring entity, contact person, tender details and the documents you upload.</li>
            <li><strong>Prequalification:</strong> company details, TRN, contact person, trades and the certificates you upload with their numbers and expiry dates.</li>
            <li><strong>Job applications:</strong> your name, phone, email, parish, experience, qualifications and CV if you attach one.</li>
            <li><strong>Messages:</strong> your name, contact details and message.</li>
        </ul>
        <h2>Why, and who sees it</h2>
        <p>We use these details only to respond: to decide whether to bid, to assess and manage subcontractors and suppliers, to consider applicants for work, and to reply to messages. Each kind of submission is seen only by the staff who handle it (estimating, procurement or human resources) and the site administrator. We do not sell or share them for marketing.</p>
        <h2>Where it is kept</h2>
        <p>Uploads are stored on a private part of our web server that is not reachable from the internet; staff open them after signing in. Emails confirming your reference number are sent from our website.</p>
        <h2>How long</h2>
        <ul>
            <li>Tender records: for the life of the tender and any resulting contract, plus the period our records rules require.</li>
            <li>Prequalification records: while you remain on our approved list. We email a renewal link before a certificate expires.</li>
            <li>Job applications: up to 12 months, unless you ask us to delete yours sooner.</li>
        </ul>
        <h2>Your rights</h2>
        <p>You can ask to see, correct or delete the details we hold about you by emailing <a href="mailto:{{ yps('email') }}">{{ yps('email') }}</a>. Quote your reference number if you have one.</p>
        <h2>Cookies</h2>
        <p>The site uses one session cookie to keep forms secure and a setting that remembers light or dark mode. There is no advertising or tracking.</p>
        <p class="hint">Last updated {{ now()->format('F Y') }}. To be reviewed by the firm before launch.</p>
    </section>
</x-layouts.site>
