<?php

/*
|--------------------------------------------------------------------------
| Y.P. Seaton & Associates: facts the site is built from
|--------------------------------------------------------------------------
| Every fact here comes from the firm's archived website (ypseaton.com, Wayback Machine
| 2015–2022) or a dated news / government source listed against it. Nothing is invented:
| no staff list, certifications, NCC grade, testimonials or project values beyond what a
| source states. See "Before launch: confirm with the client" in README.md.
| Read with yps('key').
*/

return [

    'name' => 'Y.P. Seaton & Associates Company Limited',
    'short_name' => 'Y.P. Seaton & Associates',
    'alternate_names' => ['Y.P. Seaton Group', 'YP Seaton & Associates', 'YPS'],
    'founded' => 1969,
    'description' => 'Y.P. Seaton & Associates is a Kingston civil engineering and building contractor, founded in 1969: shoreline protection, sewerage and water works, housing infrastructure, roads and drainage across Jamaica.',
    'footer_line' => 'Civil engineering and building contractors in Jamaica since 1969.',
    // The firm's own tagline, from its logo on the 2014–2019 site.
    'tagline' => 'High Quality Results At All Times',

    'phone' => '+18769235491',
    // The old site printed "923-5491-5" (lines 5491 to 5495, presumably). Confirm before launch.
    'phone_note' => 'Lines 923-5491 to 5495',
    'fax' => '+18769235788',
    'email' => env('YPS_PUBLIC_EMAIL', 'info@ypseaton.com'),
    'address' => [
        'street' => '52c Molynes Road',
        'city' => 'Kingston 10',
        'country' => 'Jamaica',
    ],
    'website' => 'www.ypseaton.com',
    'map_url' => 'https://www.google.com/maps/search/?api=1&query=52c+Molynes+Road+Kingston+10+Jamaica',
    // From the 2014–2019 site. Confirm they still apply.
    'hours' => [
        ['Monday to Thursday', '8:30 am – 5:30 pm'],
        ['Friday', '8:30 am – 4:30 pm'],
    ],

    // Concept preview: banner + noindex until the client signs off.
    'preview' => (bool) env('YPS_PREVIEW', true),

    // Who is emailed about new submissions. Each area falls back to the default.
    'notify' => [
        'default' => env('YPS_NOTIFY_EMAIL', ''),
        'tenders' => env('YPS_NOTIFY_TENDERS', ''),
        'prequal' => env('YPS_NOTIFY_PREQUAL', ''),
        'careers' => env('YPS_NOTIFY_CAREERS', ''),
        'enquiries' => env('YPS_NOTIFY_ENQUIRIES', ''),
        'rooms' => env('YPS_NOTIFY_ROOMS', ''),
    ],

    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrator'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    'capability_pdf' => 'YP-Seaton-Capability-Statement.pdf',

    /*
    | About. The intro is a summary written for this site from the firm's history and the
    | contracts below. The paragraphs are the firm's own words from its 2015–2022 website and
    | the mission from its 2015–2018 website, lightly trimmed. The principal's name and title
    | are as the UDC published them in April 2015.
    */
    'about' => [
        'intro' => 'From small beginnings in 1969 as electrical and mechanical engineering contractors, Y.P. Seaton & Associates grew into a general civil engineering and building contractor. Today its work for government agencies includes shoreline protection, sewage conveyance, housing infrastructure, irrigation and road works.',
        'paragraphs' => [
            'We take pride in quality work and in meeting deadlines, and we have managed this through a highly skilled workforce that has engineered our growth and remains committed to keeping us strong, efficient and viable.',
            'We have developed a solid performance reputation in housing development and construction, road building, water works, electrical and mechanical contracting, general construction and the provision of goods and services.',
            'Through strict adherence to our commitment to leadership in technology, performance and service, we have played a leading role in the growth and development of Jamaica\'s building and construction industry, applying the technology and expertise needed to complete projects on time and within budget.',
        ],
        'mission' => 'Maintain our position as one of the leading building and construction firms in Jamaica, displaying at all times an unswerving commitment to quality performance and excellent service. Ensure a high level of satisfaction for all our stakeholders. Provide efficient and cost-effective service to our clients. Provide quality, aesthetically pleasing low-cost and middle-income housing solutions which enhance the social, environmental and economic conditions of communities. We develop with emphasis on the training and development of our young people.',
        'source' => 'ypseaton.com, 2015–2022 (Wayback Machine)',
    ],

    'principal' => [
        'name' => 'York Seaton',
        'title' => 'Managing Director',
        'source' => ['label' => 'Urban Development Corporation', 'url' => 'https://udcja.com/udc-signs-contract-for-historic-capital-expenditure-project-in-caymanas-estate-st-catherine/', 'date' => '28 April 2015'],
    ],

    /*
    | Services. Built from the four service lines on the firm's 2014–2019 site and the work the
    | public record shows. `sector` links a service to its projects.
    */
    'services' => [
        'coastal' => [
            'title' => 'Shoreline and coastal protection',
            'sector' => 'coastal',
            'icon' => 'waves',
            'summary' => 'Composite revetments, retaining walls and concrete walls that protect roads, runways and communities from erosion, wave action, overtopping and hurricane damage.',
            'items' => ['Shoreline protection works', 'Composite revetments', 'Concrete walls to reduce overtopping', 'Retaining walls on coastal roads', 'Supply of materials for shoreline construction'],
        ],
        'water' => [
            'title' => 'Water, sewerage and irrigation',
            'sector' => 'water',
            'icon' => 'droplet',
            'summary' => 'Force mains, sewage lift stations, septic and biodigester tanks, irrigation systems and storm-water drainage for public agencies and developers.',
            'items' => ['Sewage conveyance: force mains and lift stations', 'Septic, biodigester and chlorination chambers', 'Irrigation and water supply systems', 'Storm-water systems and drainage design'],
        ],
        'housing' => [
            'title' => 'Housing and infrastructure development',
            'sector' => 'housing',
            'icon' => 'home',
            'summary' => 'Roads, water supply, drainage and sewerage for housing schemes, and the low- and middle-income housing solutions the firm was founded to deliver.',
            'items' => ['Subdivision roads and drainage', 'Water supply and sewerage for schemes', 'Housing construction', 'Property development, building management and maintenance'],
        ],
        'roads' => [
            'title' => 'Roads, retaining walls and drainage',
            'sector' => 'roads',
            'icon' => 'road',
            'summary' => 'Road construction, repair and maintenance, with the retaining walls and gully inverts that keep hillside roads open after heavy rain.',
            'items' => ['Road construction, repair and maintenance', 'Retaining walls', 'Gully inverts and drains'],
        ],
        'building' => [
            'title' => 'General building construction',
            'sector' => null,
            'icon' => 'building',
            'summary' => 'Residential and commercial buildings for private and public clients, including drawings prepared and submitted for approval, and estimates.',
            'items' => ['Residential and commercial buildings', 'Drawings prepared and submitted for approval', 'Estimates'],
        ],
        'electrical' => [
            'title' => 'Electrical and mechanical engineering',
            'sector' => null,
            'icon' => 'bolt',
            'summary' => 'Where the firm began in 1969: electrical and mechanical installation, construction, maintenance and repair.',
            'items' => ['Electrical installation, maintenance and repair', 'Lighting and power, fire alarms and emergency lighting', 'Energy-efficient and LED lighting', 'Mechanical installation, maintenance and repair'],
        ],
    ],

    'sectors' => [
        'coastal' => ['label' => 'Coastal protection'],
        'water' => ['label' => 'Water and sewerage'],
        'housing' => ['label' => 'Housing infrastructure'],
        'roads' => ['label' => 'Roads and drainage'],
    ],

    /*
    | Projects. Only contracts a dated public source attributes to the firm. "status" says what
    | the source confirms: an award or Cabinet approval is not a completion. Values in J$ millions.
    */
    'projects' => [
        'nmia-shoreline-protection' => [
            'title' => 'Shoreline protection, Runway 30 end, Norman Manley International Airport',
            'client' => 'Airports Authority of Jamaica',
            'location' => 'Port Royal Road',
            'parish' => 'Kingston',
            'sector' => 'coastal',
            'year' => 2021,
            'year_label' => '2021 (Cabinet approval)',
            'value' => 555.9,
            'value_label' => 'Contract sum authorised by Cabinet',
            'status' => 'Contract authorised by Cabinet, April 2021; works under way November 2021',
            'summary' => 'Civil works for 358 metres of shoreline protection at the eastern end of the runway, protecting the shoreline, Port Royal Road and the runway from erosion, wave action and hurricane damage.',
            'scope' => [
                '358 m of shoreline protection at the Runway 30 end',
                'Protection for Port Royal Road, the only road access to Port Royal',
                'Protection for underground electricity, water and telecoms services along the road',
            ],
            'photo' => 'kingston-aerial',
            'photo_alt' => 'Astronaut photograph of Kingston Harbour, with the Palisadoes and the airport runway along the bottom of the frame',
            'sources' => [
                ['label' => 'Jamaica Observer', 'url' => 'https://www.jamaicaobserver.com/2021/04/14/allied-brokers-to-provide-insurance-services-for-nht/', 'date' => '14 April 2021'],
                ['label' => 'CVM TV', 'url' => 'https://www.cvmtv.com/news/aaj-port-royal-road-shoreline-protection-works/', 'date' => '13 November 2021'],
            ],
            'featured' => true,
        ],
        'caymanas-sewage-conveyance' => [
            'title' => 'Caymanas Estate sewage conveyance system',
            'client' => 'Urban Development Corporation',
            'location' => 'Caymanas Estate',
            'parish' => 'St. Catherine',
            'sector' => 'water',
            'year' => 2015,
            'year_label' => '2015 (contract signed)',
            'value' => 624.0,
            'value_label' => 'Contract sum announced by the UDC',
            'status' => 'Contract signed 28 April 2015',
            'summary' => 'About 7.4 km of force main and two sewage lift stations carrying sewage from Caymanas Estate to the Soapberry Wastewater Treatment Plant.',
            'scope' => [
                'About 7.4 km of force main pipeline',
                'Two sewage lift stations',
                'Connection to the Soapberry Wastewater Treatment Plant',
            ],
            'photo' => 'clarifiers',
            'photo_alt' => 'Aerial view of circular clarifier tanks at a wastewater treatment plant',
            'sources' => [
                ['label' => 'Urban Development Corporation', 'url' => 'https://udcja.com/udc-signs-contract-for-historic-capital-expenditure-project-in-caymanas-estate-st-catherine/', 'date' => '28 April 2015'],
                ['label' => 'Jamaica Gleaner', 'url' => 'https://jamaica-gleaner.com/article/business/20150429/yp-seaton-associates-develop-600m-sewage-system-caymanas-estate', 'date' => '29 April 2015'],
            ],
            'featured' => true,
        ],
        'whitehall-phase-2' => [
            'title' => 'Whitehall Phase 2 housing infrastructure',
            'client' => 'Housing Agency of Jamaica',
            'location' => 'Whitehall',
            'parish' => 'Westmoreland',
            'sector' => 'housing',
            'year' => 2009,
            'year_label' => '2009 (Cabinet approval)',
            'value' => 283.7,
            'value_label' => 'Contract sum as reported by JIS',
            'status' => 'Contract approved by Cabinet, October 2009',
            'summary' => 'Infrastructure for a housing phase of 800 solutions: roads, water supply, storm-water drainage and sewerage.',
            'scope' => [
                'Roadways',
                'Water supply',
                'Storm-water drainage',
                'Sewerage',
            ],
            'photo' => 'paving',
            'photo_alt' => 'A road roller and asphalt paver on a newly widened road',
            'sources' => [
                ['label' => 'Jamaica Information Service', 'url' => 'https://jis.gov.jm/cabinet-approves-contracts-for-infrastructure-works/', 'date' => '22 October 2009'],
            ],
            'featured' => true,
        ],
        'annotto-bay-shoreline' => [
            'title' => 'Annotto Bay coastal shoreline construction',
            'client' => 'Government of Jamaica / Adaptation Fund Programme',
            'location' => 'Annotto Bay',
            'parish' => 'St. Mary',
            'sector' => 'coastal',
            'year' => 2021,
            'year_label' => '2021 (Cabinet approval)',
            'value' => 179.54,
            'value_label' => 'Contract sum approved by Cabinet (J$179,540,350)',
            'status' => 'Contract approved by Cabinet, January 2021',
            'summary' => 'Supply of materials and construction of coastal shoreline works at Annotto Bay under the GOJ/Adaptation Fund Programme.',
            'scope' => [
                'Supply of materials',
                'Coastal shoreline construction',
            ],
            'photo' => 'palisadoes',
            'photo_alt' => 'Boulders along the shore of the Palisadoes, looking across Kingston Harbour to the mountains',
            'sources' => [
                ['label' => 'Office of the Prime Minister, Post-Cabinet Report', 'url' => 'https://opm.gov.jm/post-cabinet-report-for-wednesday-january-20-2021/', 'date' => '20 January 2021'],
            ],
            'featured' => false,
        ],
        'buff-bay-shoreline' => [
            'title' => 'Buff Bay shoreline protection',
            'client' => 'GOJ / Adaptation Fund Programme (Planning Institute of Jamaica)',
            'location' => 'A4 main road, Buff Bay',
            'parish' => 'Portland',
            'sector' => 'coastal',
            'year' => 2020,
            'year_label' => '2020 (contract signed)',
            'value' => 40.9486,
            'value_label' => 'Contract sum (J$40,948,600)',
            'status' => 'Contract signed 12 October 2020; four-month construction period',
            'summary' => 'A composite revetment to attenuate wave energy and stop waves breaking on the shoreline, with a concrete wall to reduce overtopping and shield the coastal cliff along the A4.',
            'scope' => [
                'Composite revetment',
                'Concrete wall to reduce overtopping and shield the coastal cliff',
                'Four-month construction period',
            ],
            'photo' => 'revetment',
            'photo_alt' => 'An excavator and loader building a two-layer rock revetment by the sea',
            'sources' => [
                ['label' => 'Planning Institute of Jamaica', 'url' => 'https://www.pioj.gov.jm/goj-adaptation-fund-programme-awards-contract-for-shoreline-protection-works/', 'date' => 'October 2020'],
            ],
            'featured' => false,
        ],
        'stokes-hall-biodigester' => [
            'title' => 'Stokes Hall biodigester septic tank and chlorination chamber',
            'client' => 'Sugar Transformation Programme, Barracks Relocation Project',
            'location' => 'Stokes Hall',
            'parish' => 'St. Thomas',
            'sector' => 'water',
            'year' => 2014,
            'year_label' => '2014 (Cabinet approval)',
            'value' => 47.7,
            'value_label' => 'Approximate contract sum as reported by JIS',
            'status' => 'Contract approved by Cabinet, May 2014',
            'summary' => 'Construction of a biodigester septic tank and chlorination chamber, with pipe works, manholes and a reed bed, for the Barracks Relocation Project of the Sugar Transformation Programme.',
            'scope' => [
                'Biodigester septic tank',
                'Chlorination chamber',
                'Pipe works, manholes and a reed bed',
            ],
            'photo' => 'concrete-pour',
            'photo_alt' => 'Concrete pump booms and mixer trucks pouring a foundation slab',
            'sources' => [
                ['label' => 'Jamaica Information Service', 'url' => 'https://jis.gov.jm/cabinet-approves-contract-stokes-hall-biodigester-septic-tank/', 'date' => '30 May 2014'],
            ],
            'featured' => false,
        ],
        'seven-rivers-irrigation' => [
            'title' => 'Seven Rivers irrigation system',
            'client' => 'Government of Jamaica',
            'location' => 'Seven Rivers',
            'parish' => 'St. James',
            'sector' => 'water',
            'year' => 2004,
            'year_label' => '2004 (Cabinet approval)',
            'value' => 23.8,
            'value_label' => 'Contract sum as reported by JIS',
            'status' => 'Contract approved by Cabinet, February 2004',
            'summary' => 'Construction of an irrigation system at Seven Rivers, one of three irrigation contracts approved by Cabinet and announced by the Minister of Water and Housing among new irrigation systems for rural Jamaica.',
            'scope' => [
                'Irrigation system construction',
            ],
            'photo' => 'excavator',
            'photo_alt' => 'A tracked excavator lifting a full bucket of soil',
            'sources' => [
                ['label' => 'Jamaica Information Service', 'url' => 'https://jis.gov.jm/new-irrigation-systems-for-rural-jamaica/', 'date' => '6 February 2004'],
            ],
            'featured' => false,
        ],
        'aston-ridge-retaining-wall' => [
            'title' => 'Aston Ridge Road retaining wall and gully invert',
            'client' => null,
            'location' => 'Aston Ridge Road, upper St. Andrew',
            'parish' => 'St. Andrew',
            'sector' => 'roads',
            'year' => null,
            'year_label' => null,
            'value' => 9.6,
            'value_label' => 'Final cost, within a revised contract sum of J$10.5 million',
            'status' => 'Completed; reported as satisfactorily completed by the Ministry',
            'summary' => 'A retaining wall and gully invert on a hillside road in upper St. Andrew, completed for J$9.6 million against a revised contract sum of J$10.5 million.',
            'scope' => [
                'Retaining wall',
                'Gully invert',
            ],
            'photo' => 'river-revetment',
            'photo_alt' => 'A concrete slope revetment along a river bank under a road bridge',
            'sources' => [
                ['label' => 'Ministry of Transport and Mining', 'url' => 'https://mtm.gov.jm/?p=890', 'date' => null],
            ],
            'featured' => false,
        ],
    ],

    // Prequalification: trades and supply categories a vendor can tick.
    'trades' => [
        'earthworks' => 'Earthworks and excavation',
        'marine' => 'Marine and coastal works',
        'armour' => 'Armour stone and boulders',
        'aggregates' => 'Aggregates and quarry products',
        'concrete' => 'Ready-mix concrete and pumping',
        'formwork' => 'Formwork and falsework',
        'steel' => 'Reinforcement and steel fixing',
        'masonry' => 'Blockwork and masonry',
        'pipes' => 'Pipes, fittings and precast',
        'plant' => 'Plant hire with operators',
        'haulage' => 'Trucking and haulage',
        'electrical' => 'Electrical installation',
        'mechanical' => 'Plumbing and mechanical',
        'finishing' => 'Finishes, roofing and carpentry',
        'survey' => 'Land surveying and setting out',
        'testing' => 'Materials and soil testing',
        'safety' => 'Traffic management and site safety',
    ],

    'parishes' => ['Kingston', 'St. Andrew', 'St. Catherine', 'Clarendon', 'Manchester', 'St. Elizabeth', 'Westmoreland', 'Hanover', 'St. James', 'Trelawny', 'St. Ann', 'St. Mary', 'Portland', 'St. Thomas'],

    'careers' => [
        'points' => [
            ['title' => 'Project by project', 'text' => 'Most site roles are tied to a contract. Leave a general application and we call you when a project in your parish starts.'],
            ['title' => 'No CV needed for site roles', 'text' => 'Tradesmen, operators and drivers can apply with a phone number and a few details. Engineers and office roles attach a CV.'],
            ['title' => 'Training young people', 'text' => 'The firm\'s mission includes the training and development of young people. Tell us what you want to learn.'],
        ],
    ],

    /*
    | Photos: public/img/{key}-{480,960,1920}.webp. Credits in config/photo-credits.php.
    */
    'photos' => [
        'revetment' => ['w' => 1920, 'h' => 1440],
        'excavator' => ['w' => 1920, 'h' => 1280],
        'kingston-aerial' => ['w' => 1920, 'h' => 1278],
        'palisadoes' => ['w' => 1920, 'h' => 1080],
        'boj' => ['w' => 1920, 'h' => 1080],
        'clarifiers' => ['w' => 1920, 'h' => 1080],
        'concrete-pour' => ['w' => 1920, 'h' => 1282],
        'paving' => ['w' => 1920, 'h' => 1080],
        'river-revetment' => ['w' => 1920, 'h' => 1440],
    ],
    // The firm's own photographs. Every other photo is illustrative and is labelled so.
    'own_photos' => ['boj'],
    'og_photo' => 'revetment',

    // Pages on the firm's old WordPress site (2014–2019), still linked from directories.
    'legacy_redirects' => [
        '/contact-us' => '/contact',
        '/water-works' => '/services#water',
        '/property-development' => '/services#housing',
        '/general-construction-infrastructure-development' => '/services#building',
        '/electrical-mechanical-construction' => '/services#electrical',
    ],
];
