<!DOCTYPE html>
<html lang="cs" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGROPLAN, spol. s r.o. | Pozemkové úpravy a geodézie</title>
    <meta name="description" content="Projektování komplexních i jednoduchých pozemkových úprav, geodetické činnosti. Agroplan s.r.o. sídlící v Praze, působící po celé ČR.">
    <link rel="shortcut icon" href="favicon.ico">
    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        agroplan: {
                            light: '#4ade80',
                            DEFAULT: '#16a34a',
                            dark: '#14532d',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Analytics Tracker -->
    <script src="/js/tracker.js" defer></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="#" class="flex items-center gap-3 group">
                        <img class="h-12 w-auto group-hover:scale-105 transition-transform" src="/images/logo-agroplan.png" alt="AGROPLAN logo">
                        <span class="font-bold text-xl text-agroplan-dark tracking-wide hidden sm:block">AGROPLAN</span>
                    </a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#onas" class="text-gray-600 hover:text-agroplan font-medium transition-colors">O Nás</a>
                    <a href="#upravy" class="text-gray-600 hover:text-agroplan font-medium transition-colors">Pozemkové úpravy</a>
                    <a href="#sluzby" class="text-gray-600 hover:text-agroplan font-medium transition-colors">Geodézie</a>
                    <a href="#reference" class="text-gray-600 hover:text-agroplan font-medium transition-colors">Reference</a>
                    <a href="#kontakt" class="text-white bg-agroplan hover:bg-agroplan-dark px-5 py-2 rounded-full font-medium transition-colors shadow-md hover:shadow-lg">Kontakt</a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-600 hover:text-agroplan focus:outline-none" id="mobile-menu-btn">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center pt-20">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="/images/bg-banner.jpg" alt="Krajina Agroplan" class="w-full h-full object-cover object-center" />
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-agroplan-dark/80 mix-blend-multiply"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-16" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 drop-shadow-lg tracking-tight">
                Tvoříme budoucnost <br/><span class="text-agroplan-light">české krajiny</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-10 font-light drop-shadow">
                Specialisté na projektování pozemkových úprav a geodetické činnosti s tradicí.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#onas" class="px-8 py-4 bg-agroplan text-white rounded-full font-semibold text-lg hover:bg-agroplan-dark hover:-translate-y-1 transition-all duration-300 shadow-xl hover:shadow-2xl">Zobrazit více</a>
                <a href="#kontakt" class="px-8 py-4 bg-white/10 text-white backdrop-blur-sm border border-white/30 rounded-full font-semibold text-lg hover:bg-white/20 hover:-translate-y-1 transition-all duration-300">Napište nám</a>
            </div>
        </div>
    </section>

    <!-- O nás -->
    <section id="onas" class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div data-aos="fade-right" data-aos-duration="800">
                    <h2 class="text-sm font-bold text-agroplan uppercase tracking-wider mb-2">Historie & Současnost</h2>
                    <h3 class="text-4xl font-bold text-gray-900 mb-6">O společnosti Agroplan</h3>
                    <div class="w-20 h-1 bg-agroplan mb-8"></div>
                    
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Agroplan, s.r.o. navázala v roce 1992 na činnost původního Agroplanu, který existoval již od roku 1969. Hlavní náplní naší firmy je <strong>projektování pozemkových úprav</strong>.
                    </p>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Začínali jsme s jednoduchými pozemkovými úpravami a postupně přešli ke komplexním projektům, včetně výměny vlastnictví a digitální katastrální mapy. Dnes zajišťujeme kompletní realizační projekty pro polní cesty, biocentra a protierozní opatření.
                    </p>
                    
                    <div class="flex items-center gap-4 mt-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="w-12 h-12 bg-agroplan/10 rounded-full flex items-center justify-center text-agroplan">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">100% Schválení vlastníky</p>
                            <p class="text-sm text-gray-500">Veškeré naše projekty odevzdáváme v náležité kvalitě.</p>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="absolute -inset-4 bg-agroplan/20 rounded-3xl transform rotate-3 transition-transform hover:rotate-6 duration-500"></div>
                    <img src="/images/onas-01.jpg" alt="Terénní práce" class="relative rounded-2xl shadow-2xl object-cover h-[500px] w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Pozemkové úpravy -->
    <section id="upravy" class="py-24 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-sm font-bold text-agroplan uppercase tracking-wider mb-2">Naše specializace</h2>
                <h3 class="text-4xl font-bold text-gray-900 mb-4">Pozemkové úpravy</h3>
                <div class="w-24 h-1 bg-agroplan mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Karta 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border border-gray-100 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-agroplan/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-agroplan group-hover:text-white transition-colors text-agroplan">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Vlastnické vztahy</h4>
                    <p class="text-gray-600 leading-relaxed">Vyřešení složitých vlastnických vztahů bránících racionálnímu hospodaření. Pozemkové úpravy jsou nástrojem krajinného plánování.</p>
                </div>
                <!-- Karta 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border border-gray-100 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-agroplan/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-agroplan group-hover:text-white transition-colors text-agroplan">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Prospěšná opatření</h4>
                    <p class="text-gray-600 leading-relaxed">Návrhy a projektování společných zařízení jako jsou polní a lesní cesty, protipovodňová a protierozní opatření, biocentra.</p>
                </div>
                <!-- Karta 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 border border-gray-100 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-agroplan/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-agroplan group-hover:text-white transition-colors text-agroplan">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Katastrální operát</h4>
                    <p class="text-gray-600 leading-relaxed">Výsledky našich úprav slouží pro obnovu katastrálního operátu a jako nezbytný podklad pro budoucí územní plánování.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Reference -->
    <section id="reference" class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 rounded-3xl p-8 md:p-12 flex flex-col md:flex-row gap-12 items-center" data-aos="zoom-in" data-aos-duration="800">
                <div class="w-full md:w-1/3 hover:scale-105 transition-transform duration-500">
                    <img src="/images/eu.jpg" alt="Projekt EU" class="rounded-xl shadow-md w-full">
                </div>
                <div class="w-full md:w-2/3">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Rozvoj automatizace a digitalizace</h3>
                    <p class="text-gray-600 mb-4">
                        <strong>Projekt je realizován v naší provozovně v Ústí nad Orlicí</strong> v rámci Operačního programu Podnikání a inovace pro konkurenceschopnost.
                    </p>
                    <p class="text-gray-600 mb-4">
                        Předmětem projektu je pořízení a implementace technologií do firemního zázemí. Cílem projektu je podpořit růst a posílit konkurenceschopnost společnosti, a to především díky novým technologiím.
                    </p>
                    <div class="inline-block bg-white px-4 py-2 rounded-lg text-sm text-gray-500 shadow-sm border border-gray-100">
                        Reg. číslo: CZ.01.2.06/0.0/0.0/19_250/0019314
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontakt -->
    <section id="kontakt" class="py-24 bg-agroplan-dark text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div data-aos="fade-right" data-aos-duration="800">
                    <h2 class="text-4xl font-bold mb-8">Kontaktujte nás</h2>
                    <p class="text-gray-300 mb-12 text-lg">Jsme připraveni s vámi konzultovat váš projekt a nabídnout nejlepší řešení.</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-agroplan-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">AGROPLAN, spol. s r.o.</h4>
                                <p class="text-gray-300">Jeremenkova 9, 147 00 Praha 4</p>
                                <p class="text-sm text-gray-400 mt-1">IČO: 48110141 | DIČ: CZ48110141 | ID DS: pb5jxk5</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-agroplan-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">E-mail</h4>
                                <a href="mailto:info@agroplan.cz" class="text-gray-300 hover:text-white transition-colors">info@agroplan.cz</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-agroplan-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold">Telefon</h4>
                                <p class="text-gray-300">Ústředna: +420 241 431 672</p>
                                <p class="text-gray-300">Pozemkové úpravy: +420 732 932 135 (Ing. Petr Kubů)</p>
                                <p class="text-gray-300">Geodézie: +420 737 586 726 (Ing. Jan Petrásek)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="h-[400px] rounded-2xl overflow-hidden shadow-2xl relative z-10" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <iframe width="100%" height="100%" frameborder="0" style="border:0;" src="https://maps.google.com/maps?q=Jeremenkova%209,%20147%2000%20Praha%204&t=&z=16&ie=UTF8&iwloc=&output=embed" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-black text-white py-8 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center items-center">
            <p class="text-gray-400 text-sm">&copy; <?= date('Y') ?> AGROPLAN, spol. s r.o. Všechna práva vyhrazena.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.classList.add('shadow-md');
                nav.classList.remove('bg-white/90');
                nav.classList.add('bg-white');
            } else {
                nav.classList.remove('shadow-md');
                nav.classList.remove('bg-white');
                nav.classList.add('bg-white/90');
            }
        });
    </script>
    
    <!-- AOS Animation script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 100
        });
    </script>

    <!-- Cookie Consent Banner -->
    <div id="cookie-banner" class="fixed bottom-0 inset-x-0 pb-2 sm:pb-5 z-50 hidden transform transition-transform duration-500 translate-y-full">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="p-4 rounded-2xl bg-white shadow-2xl border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Ochrana soukromí a Cookies</h3>
                    <p class="text-sm text-gray-600">
                        Tento web používá k poskytování služeb, personalizaci a analýze návštěvnosti soubory cookie. 
                        Kliknutím na "Přijmout vše" souhlasíte s používáním všech cookies. Můžete také vybrat jen nezbytné.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button id="cookie-reject" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors whitespace-nowrap">
                        Pouze nezbytné
                    </button>
                    <button id="cookie-accept" class="px-5 py-2.5 text-sm font-medium text-white bg-agroplan hover:bg-agroplan-dark rounded-xl shadow hover:shadow-lg transition-colors whitespace-nowrap">
                        Přijmout vše
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cookie Banner Logic
        document.addEventListener('DOMContentLoaded', () => {
            const banner = document.getElementById('cookie-banner');
            const btnAccept = document.getElementById('cookie-accept');
            const btnReject = document.getElementById('cookie-reject');

            if (!localStorage.getItem('cookie_consent_answered')) {
                // Show banner
                banner.classList.remove('hidden');
                setTimeout(() => {
                    banner.classList.remove('translate-y-full');
                }, 100);
            } else if (localStorage.getItem('cookie_consent_analytics') === 'true') {
                // Load tracker if previously accepted
                initTracker();
            }

            const hideBanner = () => {
                banner.classList.add('translate-y-full');
                setTimeout(() => {
                    banner.classList.add('hidden');
                }, 500);
            };

            btnAccept.addEventListener('click', () => {
                localStorage.setItem('cookie_consent_answered', 'true');
                localStorage.setItem('cookie_consent_analytics', 'true');
                hideBanner();
                initTracker(); // Z tracker.js
            });

            btnReject.addEventListener('click', () => {
                localStorage.setItem('cookie_consent_answered', 'true');
                localStorage.setItem('cookie_consent_analytics', 'false');
                hideBanner();
                // Nespuštíme tracker
            });
        });
    </script>
</body>
</html>
