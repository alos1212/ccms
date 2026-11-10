@extends('layouts.site')

@section('title', config('app.name', 'CCMS'))

@push('head')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-motion.css') }}?v=12">
    <link rel="stylesheet" href="{{ asset('css/home-focus.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-planter.css') }}?v=15">
    <link rel="stylesheet" href="{{ asset('css/home-certifications.css') }}?v=7">
    <link rel="stylesheet" href="{{ asset('css/home-about.css') }}?v=8">
    <link rel="stylesheet" href="{{ asset('css/home-services.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/home-sustainability.css') }}?v=10">
    <link rel="stylesheet" href="{{ asset('css/home-partnership.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/home-testimonials.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/home-impact.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/home-clients.css') }}?v=1">
@endpush

@section('content')
    @php
        $hero = $contents->get('hero', collect())->first();
        $about = $contents->get('about', collect())->first();
        $certifications = $contents->get('certifications', collect())->first();
        $servicesContent = $contents->get('services', collect())->first();
        $sustainabilityContents = $contents->get('sustainability', collect());
        $sustainabilityLead = $sustainabilityContents->first();
        $sustainabilityFeatures = $sustainabilityContents->skip(1)->take(3);
        $sustainabilityFallbackIcons = ['fa-people-group', 'fa-leaf', 'fa-gears'];
        $partnership = $contents->get('partnership', collect())->first();
        $testimonials = [
            [
                'quote' => '“CCMS team is always on time and friendly. They do a great job in an efficient amount of time.”',
                'name' => 'Rebecca P, Residential customer',
            ],
            [
                'quote' => '“Excellent job! Immediate response, completely thorough, and perfectly professional.”',
                'name' => 'Judith K, Residential Client.',
            ],
            [
                'quote' => '“They always do a great job cleaning. Very efficient and detailed.”',
                'name' => 'Michelle B, Residential customer',
            ],
            [
                'quote' => '“The team is dependable, professional, and always leaves our space looking excellent.”',
                'name' => 'Carlos M, Facility manager',
            ],
            [
                'quote' => '“Great communication from start to finish. We are very happy with the quality of service.”',
                'name' => 'Amanda R, Commercial customer',
            ],
            [
                'quote' => '“Consistent, courteous, and detail-oriented. CCMS has been a great partner for our property.”',
                'name' => 'Thomas S, Property manager',
            ],
        ];
        $impactContents = $contents->get('impact', collect());
        $impactHeading = $impactContents->first(function ($content): bool {
            return ! preg_match('/\d/', trim((string) $content->title));
        });
        $impactStatContents = $impactContents->reject(function ($content): bool {
            return ! preg_match('/\d/', trim((string) $content->title));
        });
        $clientContents = $contents->get('clients', collect());
        $impactFallbacks = collect([
            ['value' => 550, 'suffix' => '+', 'label' => 'millions sq. ft. cleaned'],
            ['value' => 2200, 'suffix' => '+', 'label' => 'clients served'],
            ['value' => 20, 'suffix' => '+', 'label' => 'years of service'],
        ]);
        $impactStats = $impactStatContents->isNotEmpty()
            ? $impactStatContents->take(3)->map(function ($content): array {
                $title = trim((string) $content->title);
                $value = preg_replace('/[^0-9.]/', '', $title);

                return [
                    'value' => (float) ($value ?: 0),
                    'suffix' => str_contains($title, '+') ? '+' : '',
                    'label' => $content->subtitle ?: $content->introduction ?: 'Impact delivered',
                ];
            })
            : $impactFallbacks;
        $impactKicker = $impactHeading?->subtitle ?: 'Our Impact';
        $impactTitle = $impactHeading?->title ?: 'Getting the job done — no matter the challenge.';
        $impactIntroduction = $impactHeading?->introduction;
        $homeSections = ['portfolio' => 'Our Work'];
    @endphp

    <section class="home-hero" id="home">
        <div class="home-hero-stage">
            <div class="home-hero-media" aria-hidden="true">
                <img src="{{ asset('images/page/home-hero-clean.png') }}?v=2" alt="">
                <img class="home-hero-planter" src="{{ asset('images/page/hero-planter.png') }}?v=2" alt="">
            </div>
            <div class="site-shell home-hero-inner">
                <div class="home-hero-copy">
                    <span class="home-eyebrow">{{ $hero?->subtitle ?: 'Cleaner spaces · stronger communities' }}</span>
                    <h1>{{ $hero?->title ?: 'Custom Cleaning Solutions' }}</h1>
                    <p>{{ $hero?->introduction ?: 'With exceptional service, compliance, and attention to detail.' }}</p>
                    <div class="home-hero-actions">
                        <a class="home-primary-button site-action site-action--primary" href="{{ $hero?->url ?: '#services' }}">
                            Request a Quote <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                        </a>
                        <a class="home-secondary-link site-action" href="#services">
                            Explore Our Services <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
                <div class="home-hero-note"><span>People.</span><span>Processes.</span><span>Cleaner spaces.</span><strong>Brighter tomorrows.</strong></div>
            </div>
            <section class="home-capabilities" aria-label="Capabilities">
                <div class="site-shell home-capabilities-grid">
                    <div class="home-capability"><i class="fa-solid fa-building" aria-hidden="true"></i><span>Commercial<br>Facility Services</span></div>
                    <div class="home-capability"><i class="fa-solid fa-helmet-safety" aria-hidden="true"></i><span>Construction<br>Cleaning</span></div>
                    <div class="home-capability"><i class="fa-solid fa-droplet" aria-hidden="true"></i><span>Remediation<br>and Specialty</span></div>
                    <div class="home-capability"><i class="fa-solid fa-landmark" aria-hidden="true"></i><span>Government<br>Facilities</span></div>
                    <div class="home-capability home-capability-highlight"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><span>A trusted partner<br>for a cleaner, safer,<br>healthier tomorrow.</span></div>
                </div>
            </section>
        </div>
        <span class="home-hero-scroll-hint">Scroll to explore <i class="fa-solid fa-arrow-down" aria-hidden="true"></i></span>
        <div class="home-white-slide">
            <div class="site-shell home-certifications-content">
                <div class="home-certifications-copy">
                    <span class="home-certifications-kicker">{{ $certifications?->subtitle ?: 'Certifications & designations' }}</span>
                    <span class="home-certifications-line" aria-hidden="true"></span>
                    <h2 id="home-certifications-title">{!! nl2br(e($certifications?->title ?: 'Quality you can see. Standards you can trust.')) !!}</h2>
                    <p>{{ $certifications?->introduction ?: 'Our certifications and designations reflect the quality, discipline and responsibility we bring to every space we serve.' }}</p>
                </div>

                <div class="home-certifications-showcase" aria-labelledby="home-certifications-title">
                    <div class="home-certifications-featured">
                        <article class="home-certification-card">
                            <img class="home-certification-logo" src="{{ asset('images/page/certification/Certificado5.png') }}" alt="ISO 9001:2015">
                            <strong>ISO 9001:2015</strong>
                            <small>Certified Enterprise</small>
                        </article>
                        <article class="home-certification-card">
                            <img class="home-certification-logo" src="{{ asset('images/page/certification/Certificado4.png') }}" alt="CIMS Expert">
                            <strong>CIMS Expert</strong>
                            <small>GBAC Enhanced</small>
                        </article>
                        <article class="home-certification-card">
                            <img class="home-certification-logo" src="{{ asset('images/page/certification/Certificado2.png') }}" alt="EPA Certified Firm">
                            <strong>Certified Company</strong>
                            <small>Environmental care</small>
                        </article>
                        <article class="home-certification-card">
                            <img class="home-certification-logo" src="{{ asset('images/page/certification/Certificado3.png') }}" alt="IICRC Certified Firm">
                            <strong>Certified Firm</strong>
                            <small>Industry standard</small>
                        </article>
                        <article class="home-certification-card">
                            <img class="home-certification-logo" src="{{ asset('images/page/certification/Certificado1.png') }}" alt="GBAC Trained Technician">
                            <strong>GBAC Trained</strong>
                            <small>Cleaning technician</small>
                        </article>
                    </div>

                    <div class="home-certifications-designations">
                        <span class="home-certifications-showcase-label">Designations</span>
                        <span class="home-certification-badge">WOSB</span>
                        <span class="home-certification-badge">EDWOSB</span>
                        <span class="home-certification-badge">8(a) <small>SDB</small></span>
                        <span class="home-certification-badge">ACDBE/DBE</span>
                        <span class="home-certification-badge">SBE</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-about home-reveal" id="about" data-home-reveal>
        <div class="site-shell home-about-grid">
            <div class="home-about-copy">
                <span class="home-about-kicker">{{ $about?->subtitle ?: 'About CCMS' }}</span>
                <span class="home-about-line" aria-hidden="true"></span>
                <h2>{{ $about?->title ?: 'We are a custom cleaning and management service contractor.' }}</h2>
                <p>{{ $about?->introduction ?: 'We serve each and every client with specially designed solutions to meet their unique needs.' }}</p>
                <a class="home-about-button site-action" href="{{ $about?->url ?: '#services' }}" @if($about?->open_in_new_tab) target="_blank" rel="noopener" @endif>
                    Learn More <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                </a>
            </div>

            <figure class="home-about-visual">
                <span class="home-about-arc home-about-arc--outer" aria-hidden="true"></span>
                <span class="home-about-arc home-about-arc--middle" aria-hidden="true"></span>
                <span class="home-about-arc home-about-arc--inner" aria-hidden="true"></span>
                <img src="{{ $about?->image ? asset('storage/'.$about->image) : asset('images/page/about-ccms.png') }}" alt="{{ $about?->title ?: 'CCMS cleaning and management services' }}">
            </figure>

            <div class="home-about-features" aria-label="CCMS values">
                <div class="home-about-feature"><i class="fa-solid fa-people-group" aria-hidden="true"></i><span>People-First Service</span></div>
                <div class="home-about-feature"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><span>Quality and Compliance</span></div>
                <div class="home-about-feature"><i class="fa-solid fa-leaf" aria-hidden="true"></i><span>Sustainable Practices</span></div>
                <div class="home-about-feature"><i class="fa-solid fa-chart-column" aria-hidden="true"></i><span>Reliable Results</span></div>
            </div>
        </div>
    </section>

    @php
        $serviceFallbacks = [
            ['title' => 'Commercial Facility Services', 'slug' => 'commercial-facility-services', 'image' => 'images/page/home-hero-clean.png'],
            ['title' => 'Construction Cleaning', 'slug' => 'construction-cleaning', 'image' => 'images/page/certification/Construction.png'],
            ['title' => 'Remediation and Specialty', 'slug' => 'remediation-and-specialty', 'image' => 'images/page/about-ccms.png'],
            ['title' => 'Government Facilities', 'slug' => 'government-facilities', 'image' => 'images/page/home-hero.png'],
        ];
        $serviceFallbackImages = collect($serviceFallbacks)->pluck('image', 'slug')->all();
        $serviceItems = $services->isNotEmpty() ? $services : collect($serviceFallbacks);
        $serviceIcons = ['fa-building', 'fa-helmet-safety', 'fa-droplet', 'fa-landmark'];
        $servicesLink = route('services.index');
    @endphp

    <section class="home-services home-reveal" id="services" data-home-reveal>
        <div class="site-shell">
            <div class="home-services-heading">
                <div class="home-services-label">
                    <span>{{ $servicesContent?->subtitle ?: 'Our Services' }}</span>
                    <i aria-hidden="true"></i>
                </div>
                <h2>{!! nl2br(e($servicesContent?->title ?: 'Forward-thinking solutions designed for your unique needs.')) !!}</h2>
                @if ($servicesContent?->introduction)
                    <p class="home-services-introduction">{{ $servicesContent->introduction }}</p>
                @endif
                <a class="home-services-link site-action" href="{{ $servicesLink }}" @if($services->first()?->open_in_new_tab) target="_blank" rel="noopener" @endif>
                    View All Services <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                </a>
            </div>

            <div class="home-services-grid">
                @foreach ($serviceItems as $index => $service)
                    @php
                        $serviceImage = data_get($service, 'image');
                        $serviceSlug = data_get($service, 'slug');
                        $serviceUrl = $serviceSlug ? route('services.show', ['service' => $serviceSlug]) : '#contact';
                        $serviceImage = $serviceImage
                            ? (str_starts_with($serviceImage, 'images/') ? asset($serviceImage) : asset('storage/'.$serviceImage))
                            : asset($serviceFallbackImages[$serviceSlug] ?? $serviceFallbacks[$index % count($serviceFallbacks)]['image']);
                        $serviceIcon = data_get($service, 'icon') ?: $serviceIcons[$index % count($serviceIcons)];
                    @endphp
                    <a class="home-service-card" href="{{ $serviceUrl }}" @if(data_get($service, 'open_in_new_tab')) target="_blank" rel="noopener" @endif>
                        <div class="home-service-card-image">
                            <div class="home-service-image-viewport">
                                <img src="{{ $serviceImage }}" alt="{{ data_get($service, 'title') }}">
                            </div>
                            <span class="home-service-icon"><i class="fa-solid {{ $serviceIcon }}" aria-hidden="true"></i></span>
                        </div>
                        <div class="home-service-card-body">
                            <div><h3>{{ data_get($service, 'title') }}</h3>@if(data_get($service, 'subtitle'))<p>{{ data_get($service, 'subtitle') }}</p>@endif</div>
                            <span class="home-service-arrow" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="home-impact home-reveal" id="impact" data-home-reveal>
        <div class="site-shell home-impact-inner">
            <div class="home-impact-copy">
                <span class="home-impact-kicker">{{ $impactKicker }}</span>
                <span class="home-impact-line" aria-hidden="true"></span>
                <h2>{!! nl2br(e($impactTitle)) !!}</h2>
                @if ($impactIntroduction)
                    <p class="home-impact-introduction">{{ $impactIntroduction }}</p>
                @endif
            </div>

            <div class="home-impact-stats" aria-label="CCMS impact statistics">
                @foreach ($impactStats as $stat)
                    <article class="home-impact-stat" data-impact-counter data-target="{{ $stat['value'] }}">
                        <div class="home-impact-number"><span data-counter-value>0</span><sup>{{ $stat['suffix'] }}</sup></div>
                        <p>{{ $stat['label'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if ($clientContents->isNotEmpty())
        <section class="home-clients home-reveal" id="clients" data-home-reveal>
            <div class="site-shell">
                <div class="home-clients-heading">
                    <span class="home-clients-kicker">Trusted by leading organizations</span>
                    <span class="home-clients-line" aria-hidden="true"></span>
                </div>
            </div>

            <div class="home-clients-marquee" aria-label="Clientes de CCMS">
                <div class="home-clients-track">
                    @foreach ([$clientContents, $clientContents] as $clientGroup)
                        <div class="home-clients-group" @if ($loop->last) aria-hidden="true" @endif>
                            @foreach ($clientGroup as $client)
                                @php
                                    $clientImage = str_starts_with((string) $client->image, 'images/')
                                        ? asset($client->image)
                                        : asset('storage/'.$client->image);
                                @endphp
                                <div class="home-client-logo" title="{{ $client->title }}">
                                    <img src="{{ $clientImage }}" alt="{{ $client->title }}">
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($sustainabilityLead)
        <section class="home-sustainability" id="sustainability">
            <figure class="home-sustainability-visual">
                <img src="{{ $sustainabilityLead->image ? (str_starts_with($sustainabilityLead->image, 'images/') ? asset($sustainabilityLead->image) : asset('storage/'.$sustainabilityLead->image)) : asset('images/page/about-ccms.png') }}" alt="">
            </figure>
            <div class="site-shell home-sustainability-grid">
                <div class="home-sustainability-copy">
                    <span class="home-sustainability-leaf" aria-hidden="true"><i class="fa-solid {{ $sustainabilityLead->icon ?: 'fa-leaf' }}"></i></span>
                    <div class="home-sustainability-copy-content">
                        <span class="home-sustainability-kicker">{{ $sustainabilityLead->subtitle ?: 'Sustainability in Action' }}</span>
                        <h2>{!! nl2br(e($sustainabilityLead->title)) !!}</h2>
                        @if ($sustainabilityLead->introduction)
                            <p>{{ $sustainabilityLead->introduction }}</p>
                        @endif
                        @if ($sustainabilityLead->url)
                            <a class="home-sustainability-link site-action" href="{{ $sustainabilityLead->url }}" @if($sustainabilityLead->open_in_new_tab) target="_blank" rel="noopener" @endif>
                                {{ $sustainabilityLead->link_label ?: 'Our Approach' }} <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="home-sustainability-features" aria-label="Sustainability commitments">
                    @foreach ($sustainabilityFeatures as $feature)
                        <div class="home-sustainability-feature">
                            <span class="home-sustainability-feature-icon"><i class="fa-solid {{ $feature->icon ?: $sustainabilityFallbackIcons[$loop->index % count($sustainabilityFallbackIcons)] }}" aria-hidden="true"></i></span>
                            <div>
                                <strong>{{ $feature->title }}</strong>
                                @if ($feature->introduction)<p>{{ $feature->introduction }}</p>@endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($partnership)
        <section class="home-partnership" id="partnership">
            <div class="home-partnership-visual" aria-hidden="true">
                <img src="{{ $partnership->image ? (str_starts_with($partnership->image, 'images/') ? asset($partnership->image) : asset('storage/'.$partnership->image)) : asset('images/page/home-hero.png') }}" alt="">
            </div>
            <div class="site-shell home-partnership-shell">
                <div class="home-partnership-copy">
                    <span class="home-partnership-kicker">{{ $partnership->subtitle ?: "Let's build cleaner, healthier spaces together" }}</span>
                    <h2>{{ $partnership->title }}</h2>
                    @if ($partnership->introduction)
                        <p>{{ $partnership->introduction }}</p>
                    @endif
                    @if ($partnership->url)
                        <a class="home-partnership-link site-action site-action--primary" href="{{ $partnership->url }}" @if($partnership->open_in_new_tab) target="_blank" rel="noopener" @endif>
                            {{ $partnership->link_label ?: 'Request a Quote' }} <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <section class="home-testimonials" id="testimonials" aria-labelledby="testimonials-title">
        <div class="site-shell home-testimonials-shell">
            <div class="home-testimonials-heading">
                <div>
                    <h2 id="testimonials-title">What clients say</h2>
                    <span class="home-testimonials-line" aria-hidden="true"></span>
                </div>
            </div>
            <div class="home-testimonials-carousel">
                <button type="button" class="home-testimonials-arrow" data-testimonial-direction="previous" aria-label="Previous testimonials"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button>
                <div class="home-testimonials-viewport">
                    <div class="home-testimonials-track">
                        @foreach ($testimonials as $testimonial)
                            <article class="home-testimonial-card">
                                <span class="home-testimonial-icon" aria-hidden="true"><i class="fa-regular fa-comments"></i></span>
                                <p class="home-testimonial-quote">{{ $testimonial['quote'] }}</p>
                                <strong>{{ $testimonial['name'] }}</strong>
                                <div class="home-testimonial-stars" aria-label="5 out of 5 stars">
                                    @for ($star = 0; $star < 5; $star++)
                                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                                    @endfor
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="home-testimonials-arrow" data-testimonial-direction="next" aria-label="Next testimonials"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
            </div>
            <div class="home-testimonials-dots home-testimonials-dots--desktop" aria-label="Testimonial navigation">
                @for ($slide = 0; $slide <= max(count($testimonials) - 3, 0); $slide++)
                    <button type="button" class="home-testimonial-dot @if($slide === 0) is-active @endif" data-testimonial-index="{{ $slide }}" aria-label="Show testimonials {{ $slide + 1 }}" aria-selected="{{ $slide === 0 ? 'true' : 'false' }}"></button>
                @endfor
            </div>
            <div class="home-testimonials-dots home-testimonials-dots--mobile" aria-label="Testimonial navigation">
                @foreach ($testimonials as $testimonial)
                    <button type="button" class="home-testimonial-dot @if($loop->first) is-active @endif" data-testimonial-index="{{ $loop->index }}" aria-label="Show testimonial {{ $loop->iteration }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}"></button>
                @endforeach
            </div>
        </div>
    </section>

    @foreach ($homeSections as $sectionKey => $sectionLabel)
        @php($sectionContents = $contents->get($sectionKey, collect()))
        @if ($sectionContents->isNotEmpty())
            @php($lead = $sectionContents->first())
            <section class="home-story home-reveal" id="{{ $sectionKey }}" data-home-reveal>
                <div class="site-shell home-story-grid">
                    <div class="home-story-visual">
                        @if ($lead->image)<img src="{{ asset('storage/'.$lead->image) }}" alt="{{ $lead->title }}">@else<span>{{ str_pad((string) ($loop->iteration + 1), 2, '0', STR_PAD_LEFT) }}</span>@endif
                    </div>
                    <div class="home-story-copy">
                        <span class="home-eyebrow">{{ $sectionLabel }}</span><h2>{{ $lead->title }}</h2>
                        @if ($lead->subtitle)<h3>{{ $lead->subtitle }}</h3>@endif
                        @if ($lead->introduction)<p>{{ $lead->introduction }}</p>@endif
                        @if ($lead->description)<div class="home-rich-text">{!! $lead->description !!}</div>@endif
                        @if ($lead->url)<a class="home-text-link site-action" href="{{ $lead->url }}" @if($lead->open_in_new_tab) target="_blank" rel="noopener" @endif>Discover more <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span></a>@endif
                    </div>
                </div>
                @if ($sectionContents->count() > 1)
                    <div class="site-shell home-story-cards">
                        @foreach ($sectionContents->skip(1) as $content)
                            <article class="home-mini-card"><span>{{ str_pad((string) ($loop->iteration + 1), 2, '0', STR_PAD_LEFT) }}</span><h3>{{ $content->title }}</h3>@if ($content->introduction)<p>{{ $content->introduction }}</p>@endif</article>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
    @endforeach
@endsection

@push('scripts')
    <script>
        const serviceCards = document.querySelectorAll('.home-service-card');
        const canUseServiceParallax = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

        if (canUseServiceParallax) {
            serviceCards.forEach((card) => {
                const image = card.querySelector('.home-service-card-image img');

                card.addEventListener('pointermove', (event) => {
                    const bounds = card.getBoundingClientRect();
                    const pointerX = (event.clientX - bounds.left) / bounds.width;
                    const pointerY = (event.clientY - bounds.top) / bounds.height;
                    const offsetX = (pointerX - .5) * -18;
                    const offsetY = (pointerY - .5) * -14;

                    image?.style.setProperty('--service-image-x', `${offsetX.toFixed(2)}px`);
                    image?.style.setProperty('--service-image-y', `${offsetY.toFixed(2)}px`);
                    card.style.setProperty('--service-pointer-x', `${(pointerX * 100).toFixed(2)}%`);
                    card.style.setProperty('--service-pointer-y', `${(pointerY * 100).toFixed(2)}%`);
                });

                card.addEventListener('pointerleave', () => {
                    image?.style.setProperty('--service-image-x', '0px');
                    image?.style.setProperty('--service-image-y', '0px');
                });
            });
        }

        const homeRevealItems = document.querySelectorAll('[data-home-reveal]');
        const homeRevealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) { entry.target.classList.add('is-visible'); homeRevealObserver.unobserve(entry.target); }
            });
        }, { threshold: 0.18, rootMargin: '0px 0px -8% 0px' });
        homeRevealItems.forEach((item) => homeRevealObserver.observe(item));

        const impactStats = document.querySelectorAll('[data-impact-counter]');
        const impactNumberFormatter = new Intl.NumberFormat('en-US', { maximumFractionDigits: 1 });
        const animateImpactStat = (stat) => {
            const valueElement = stat.querySelector('[data-counter-value]');
            const target = Number(stat.dataset.target || 0);
            const duration = 1700;
            const startedAt = performance.now();

            const tick = (now) => {
                const progress = Math.min((now - startedAt) / duration, 1);
                const easedProgress = 1 - Math.pow(1 - progress, 3);
                const currentValue = target * easedProgress;
                valueElement.textContent = impactNumberFormatter.format(currentValue >= target ? target : currentValue);

                if (progress < 1) requestAnimationFrame(tick);
            };

            requestAnimationFrame(tick);
        };

        const impactObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                animateImpactStat(entry.target);
                impactObserver.unobserve(entry.target);
            });
        }, { threshold: 0.45 });
        impactStats.forEach((stat) => impactObserver.observe(stat));

        const testimonialTrack = document.querySelector('.home-testimonials-track');
        const testimonialCards = document.querySelectorAll('.home-testimonial-card');
        const testimonialDots = document.querySelectorAll('.home-testimonial-dot');
        const testimonialArrows = document.querySelectorAll('[data-testimonial-direction]');
        let testimonialIndex = 0;
        let testimonialTimer;

        const isMobileTestimonials = () => window.matchMedia('(max-width: 700px)').matches;
        const positionTestimonials = () => {
            if (!testimonialTrack || !testimonialCards.length) return;
            const viewport = document.querySelector('.home-testimonials-viewport');
            const cardGap = isMobileTestimonials() ? 0 : 58;
            const cardWidth = isMobileTestimonials()
                ? viewport?.getBoundingClientRect().width || 0
                : ((viewport?.getBoundingClientRect().width || 0) - (cardGap * 2)) / 3;
            const index = isMobileTestimonials()
                ? testimonialIndex
                : Math.min(testimonialIndex, Math.max(testimonialCards.length - 3, 0));
            testimonialTrack.style.transform = `translateX(-${(cardWidth + cardGap) * index}px)`;
        };

        const showTestimonial = (index) => {
            if (!testimonialTrack || !testimonialCards.length) return;
            testimonialIndex = (index + testimonialCards.length) % testimonialCards.length;
            positionTestimonials();
            testimonialDots.forEach((dot, dotIndex) => {
                const dotIndexValue = Number(dot.dataset.testimonialIndex || 0);
                const isActive = dotIndexValue === (isMobileTestimonials() ? testimonialIndex : Math.min(testimonialIndex, testimonialCards.length - 3));
                dot.classList.toggle('is-active', isActive);
                dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
        };

        const startTestimonials = () => {
            window.clearInterval(testimonialTimer);
            testimonialTimer = window.setInterval(() => showTestimonial(testimonialIndex + 1), 5200);
        };

        testimonialDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showTestimonial(Number(dot.dataset.testimonialIndex || index));
                startTestimonials();
            });
        });
        testimonialArrows.forEach((arrow) => {
            arrow.addEventListener('click', () => {
                const direction = arrow.dataset.testimonialDirection === 'previous' ? -1 : 1;
                showTestimonial(testimonialIndex + direction);
                startTestimonials();
            });
        });
        window.addEventListener('resize', positionTestimonials);
        positionTestimonials();
        if (testimonialCards.length > 1) startTestimonials();

        const zoomScene = document.querySelector('.home-hero');
        const zoomImage = document.querySelector('.home-hero-media > img:first-child');
        const planter = document.querySelector('.home-hero-planter');
        const whiteSlide = document.querySelector('.home-white-slide');
        const whiteSlideContent = document.querySelector('.home-white-slide .home-certifications-content');
        const capabilityStrip = document.querySelector('.home-hero .home-capabilities');
        const capabilityItems = document.querySelectorAll('.home-hero .home-capability');
        const heroCopy = document.querySelector('.home-hero-copy');
        const heroNote = document.querySelector('.home-hero-note');
        const heroScrollHint = document.querySelector('.home-hero-scroll-hint');
        const siteHeader = document.querySelector('.site-header');
        let zoomFrame;
        let targetProgress = 0;
        let sceneProgress = 0;
        let animationPlayed = false;
        let sceneCollapsed = false;
        let resettingScene = false;
        let lastScrollPosition = window.scrollY;

        const syncSceneHeaderHeight = () => {
            if (!zoomScene) return;
            const headerHeight = siteHeader?.getBoundingClientRect().height || 0;
            zoomScene.style.setProperty('--home-header-height', `${headerHeight}px`);
        };

        syncSceneHeaderHeight();

        const renderZoomScene = () => {
            if (!zoomScene || !zoomImage) return;
            if (animationPlayed) {
                sceneProgress = targetProgress >= .5 ? 1 : 0;
            } else {
                sceneProgress += (targetProgress - sceneProgress) * .14;
                if (Math.abs(targetProgress - sceneProgress) < .0005) sceneProgress = targetProgress;
                if (targetProgress >= .999 && sceneProgress >= .999) animationPlayed = true;
            }
            const progress = sceneProgress;
            const exitProgress = Math.max(0, Math.min(1, progress / .52));
            const zoomProgress = Math.max(0, Math.min(1, (progress - .10) / .78));
            const slideProgress = Math.max(0, Math.min(1, (progress - .90) / .10));
            const planterProgress = Math.max(0, Math.min(1, (progress - .52) / .38));
            const planterEase = planterProgress * planterProgress * (3 - 2 * planterProgress);
            const backgroundBlur = planterEase * 8;
            const backgroundZoom = 1 + planterEase * .18;
            zoomImage.style.setProperty('--home-background-zoom', backgroundZoom.toFixed(3));
            zoomImage.style.setProperty('--home-background-blur', `${backgroundBlur.toFixed(2)}px`);
            if (planter) {
                const planterRotation = planterEase * -1.2;
                const planterCrop = Math.max(0, (planterEase - .72) / .28 * 65);
                const basePlanterWidth = window.innerWidth <= 800
                    ? Math.min(window.innerWidth * .55, 330)
                    : Math.min(window.innerWidth * .26, 380);
                const targetPlanterWidth = Math.max(
                    window.innerWidth * 3.8,
                    window.innerHeight * 3.6
                );
                const targetPlanterScale = targetPlanterWidth / basePlanterWidth;
                const planterScale = .9 + planterEase * (targetPlanterScale - .9);
                planter.style.opacity = '1';
                planter.style.width = `${(basePlanterWidth * planterScale).toFixed(2)}px`;
                planter.style.clipPath = `inset(${planterCrop.toFixed(2)}% 0 0 0)`;
                const planterLift = 47 + planterEase * 33;
                planter.style.transform = `translate(-50%, -${planterLift.toFixed(2)}%) rotate(${planterRotation.toFixed(2)}deg)`;
            }
            zoomScene.style.setProperty('--home-progress', progress.toFixed(3));
            zoomScene.style.setProperty('--home-copy-overlay-opacity', (1 - exitProgress).toFixed(3));
            if (whiteSlide) {
                const slideEase = slideProgress * slideProgress * (3 - 2 * slideProgress);
                whiteSlide.style.opacity = slideEase.toFixed(3);
                if (whiteSlideContent) {
                    const contentProgress = Math.max(0, Math.min(1, (slideProgress - .78) / .22));
                    const contentEase = contentProgress * contentProgress * (3 - 2 * contentProgress);
                    whiteSlideContent.style.opacity = contentEase.toFixed(3);
                }
            }
            if (capabilityStrip) {
                capabilityStrip.style.transform = `translateY(${(exitProgress * 110).toFixed(2)}%)`;
                capabilityStrip.style.opacity = `${1 - exitProgress}`;
            }
            capabilityItems.forEach((item, index) => {
                const direction = index % 2 === 0 ? -1 : 1;
                item.style.transform = `translate(${direction * exitProgress * (110 + index * 16)}%, ${(index % 3) * exitProgress * 28}px)`;
                item.style.opacity = `${1 - exitProgress}`;
            });
            if (heroCopy) { heroCopy.style.transform = `translateY(${-exitProgress * 70}px)`; heroCopy.style.opacity = `${1 - exitProgress}`; }
            if (heroNote) { heroNote.style.transform = `translate(${(exitProgress * 120).toFixed(2)}px, -50%)`; heroNote.style.opacity = `${1 - exitProgress}`; }
            if (heroScrollHint) { heroScrollHint.style.opacity = `${1 - exitProgress}`; }
            if (Math.abs(targetProgress - sceneProgress) > .0005) {
                zoomFrame = requestAnimationFrame(() => { zoomFrame = null; renderZoomScene(); });
            }
        };

        const getSceneStart = () => {
            const header = document.querySelector('.site-header');
            const sceneTop = zoomScene.getBoundingClientRect().top + window.scrollY;
            const headerHeight = header?.getBoundingClientRect().height || 0;

            return Math.max(0, sceneTop - headerHeight);
        };

        const collapseCompletedScene = () => {
            if (resettingScene || sceneCollapsed) return;

            resettingScene = true;
            targetProgress = 0;
            sceneProgress = 0;
            window.scrollTo({ top: getSceneStart(), left: 0, behavior: 'auto' });

            requestAnimationFrame(() => {
                zoomScene.classList.add('is-collapsed');
                sceneCollapsed = true;
                resettingScene = false;
                lastScrollPosition = window.scrollY;
                if (!zoomFrame) zoomFrame = requestAnimationFrame(() => { zoomFrame = null; renderZoomScene(); });
            });
        };

        const updateZoomScene = () => {
            if (!zoomScene) return;
            const distance = zoomScene.offsetHeight - window.innerHeight;
            const nextTargetProgress = Math.max(0, Math.min(1, -zoomScene.getBoundingClientRect().top / Math.max(distance, 1)));
            if (sceneCollapsed || resettingScene) {
                targetProgress = 0;
            } else if (animationPlayed && window.scrollY !== lastScrollPosition) {
                const scrollingUp = window.scrollY < lastScrollPosition;
                targetProgress = scrollingUp ? 0 : 1;
                if (scrollingUp) {
                    const sceneBounds = zoomScene.getBoundingClientRect();
                    const sceneIsVisible = sceneBounds.bottom > 0 && sceneBounds.top < window.innerHeight;
                    if (sceneIsVisible) collapseCompletedScene();
                }
            } else {
                targetProgress = nextTargetProgress;
            }
            lastScrollPosition = window.scrollY;
            if (!zoomFrame) zoomFrame = requestAnimationFrame(() => { zoomFrame = null; renderZoomScene(); });
        };

        window.addEventListener('scroll', () => {
            updateZoomScene();
        }, { passive: true });
        window.addEventListener('resize', () => {
            syncSceneHeaderHeight();
            updateZoomScene();
        });
        updateZoomScene();
    </script>
@endpush
