if (-not (Test-Path "bookingresort.html")) { Copy-Item "p_resort.html" "bookingresort.html" }

$resorts = @(
    @{ file="bookingresort.html"; name="Jungle Retreat Resort"; url="https://www.jungleretreat.com/" },
    @{ file="resort2.html"; name="Ranthambore Royal Retreat"; url="https://www.ranthamboreroyalretreat.com/" },
    @{ file="resort3.html"; name="Corbett River View"; url="https://www.corbettriverviewretreat.com/" },
    @{ file="resort4.html"; name="Blackbuck Eco Lodge"; url="https://www.blackbucklodge.com/" },
    @{ file="resort5.html"; name="Devalia Safari Camp"; url="https://www.devaliasafaricamp.com/" }
)

foreach ($r in $resorts) {
    $content = Get-Content $r.file -Raw
    $content = $content -replace '(?s)<title>.*?</title>', ("<title>" + $r.name + " | Luxury Safari Stay</title>")
    $content = $content -replace '(?s)<h1 class="font-serif text-5xl md:text-7xl font-bold mb-6 leading-tight">The Premier Gir Resort</h1>', ('<h1 class="font-serif text-5xl md:text-7xl font-bold mb-6 leading-tight">' + $r.name + '</h1>')
    
    $linkHtml = '<a href="' + $r.url + '" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full font-semibold transition-all inline-block shadow-lg">Official Website</a>'
    $content = $content -replace '(?s)(<button onclick="scrollToSection\(''about''\)"[^>]*>.*?More Information.*?</button>)', ("$1
                " + $linkHtml)
    
    Set-Content -Path $r.file -Value $content
}
