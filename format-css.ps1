# CSS Formatter Script
$cssFile = "c:\xampp\htdocs\VSUAmed2\assets\css\kaiadmin.min.css"
$content = Get-Content $cssFile -Raw

# Replace minified patterns with formatted versions
# This regex-based approach formats basic CSS structure

# Step 1: Add newlines after opening braces
$content = $content -replace '\{(?!\s*\n)', "{`r`n"

# Step 2: Add newlines before closing braces and add proper indentation
$content = $content -replace '(?<=[;}\)])\s*}', "`r`n}"

# Step 3: Add newlines after semicolons (but not inside calc() or other functions)
$lines = $content -split "`r`n"
$formatted = @()
$indentLevel = 0
$inSelector = $false

foreach ($line in $lines) {
    $trimmed = $line.Trim()
    
    if ($trimmed -eq "") { continue }
    
    # Detect closing braces and decrease indent
    if ($trimmed.StartsWith("}")) {
        $indentLevel = [Math]::Max(0, $indentLevel - 1)
    }
    
    # Add proper indentation
    $indent = "  " * $indentLevel
    $formatted += $indent + $trimmed
    
    # Detect opening braces and increase indent
    if ($trimmed.EndsWith("{")) {
        $indentLevel++
    }
    
    # Split properties by semicolon if multiple on one line
    if ($trimmed -match ';' -and $trimmed -notmatch '^\s*}' -and $trimmed -notmatch '^\s*[a-zA-Z0-9\.,\[\]#:]') {
        $parts = $trimmed -split ';' | Where-Object { $_ -ne "" }
        if ($parts.Count -gt 1) {
            $formatted[-1] = $indent + $parts[0] + ";"
            for ($i = 1; $i -lt $parts.Count; $i++) {
                if ($parts[$i].Trim() -ne "") {
                    $formatted += $indent + "  " + $parts[$i].Trim() + ";"
                }
            }
        }
    }
}

# Write formatted content
$formatted -join "`r`n" | Set-Content $cssFile -Encoding UTF8

Write-Host "CSS file formatted successfully!"
Write-Host "New file size: $($(Get-Item $cssFile).Length) bytes"
