{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach(['en', 'ar'] as $loc)
        <url>
            <loc>{{ url("/{$loc}") }}</loc>
            <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en') }}"/>
            <xhtml:link rel="alternate" hreflang="ar" href="{{ url('/ar') }}"/>
            <changefreq>weekly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>{{ url("/{$loc}/about") }}</loc>
            <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/about') }}"/>
            <xhtml:link rel="alternate" hreflang="ar" href="{{ url('/ar/about') }}"/>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url("/{$loc}/elevators") }}</loc>
            <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/elevators') }}"/>
            <xhtml:link rel="alternate" hreflang="ar" href="{{ url('/ar/elevators') }}"/>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
        <url>
            <loc>{{ url("/{$loc}/services") }}</loc>
            <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/services') }}"/>
            <xhtml:link rel="alternate" hreflang="ar" href="{{ url('/ar/services') }}"/>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
        <url>
            <loc>{{ url("/{$loc}/projects") }}</loc>
            <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/projects') }}"/>
            <xhtml:link rel="alternate" hreflang="ar" href="{{ url('/ar/projects') }}"/>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
        <url>
            <loc>{{ url("/{$loc}/blog") }}</loc>
            <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/blog') }}"/>
            <xhtml:link rel="alternate" hreflang="ar" href="{{ url('/ar/blog') }}"/>
            <changefreq>daily</changefreq>
            <priority>0.7</priority>
        </url>
        <url>
            <loc>{{ url("/{$loc}/contact") }}</loc>
            <xhtml:link rel="alternate" hreflang="en" href="{{ url('/en/contact') }}"/>
            <xhtml:link rel="alternate" hreflang="ar" href="{{ url('/ar/contact') }}"/>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
