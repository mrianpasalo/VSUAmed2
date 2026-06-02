# Comprehensive CSS Formatter - Full cleanup and proper indentation
$cssFile = "c:\xampp\htdocs\VSUAmed2\assets\css\kaiadmin.min.css"

# Restore from backup to start fresh
Copy-Item "$cssFile.backup" $cssFile -Force

$content = Get-Content $cssFile -Raw

# Phase 1: Normalize all whitespace around structural elements
$content = $content -replace '\s*\{\s*', " {\r\n"              # Opening braces
$content = $content -replace '\s*}\s*', "\r\n}\r\n"             # Closing braces
$content = $content -replace '\s*;\s*', ";\r\n"                  # Semicolons
$content = $content -replace ',([^\s])', ",\r\n"                 # Comma-separated selectors

# Phase 2: Split by lines and reformat with proper indentation
$lines = $content -split "`r`n" | Where-Object { $_.Trim() -ne "" }

$formatted = @()
$indentLevel = 0
$insideSelector = $false
$currentSelector = ""

foreach ($line in $lines) {
    $trimmed = $line.Trim()
    
    if ($trimmed -eq "") { continue }
    
    # Handle closing braces
    if ($trimmed -eq "}") {
        $indentLevel = [Math]::Max(0, $indentLevel - 1)
        $formatted += ("}" )
        continue
    }
    
    # Check if this is a property line (contains ':')
    $isProperty = ($trimmed -match '^\s*[a-z-]+\s*:' -and -not ($trimmed -match '^[^{]*{'))
    
    # Determine indent level
    $indent = "  " * $indentLevel
    
    if ($isProperty) {
        # This is a CSS property - add extra indentation
        $formatted += ($indent + "  " + $trimmed)
    } else {
        # This is a selector or structural element
        $formatted += ($indent + $trimmed)
        
        # Increase indent after opening brace
        if ($trimmed -match '\{$') {
            $indentLevel++
        }
    }
}

# Join with line endings
$result = $formatted -join "`r`n"

# Final cleanup - remove multiple blank lines
$result = $result -replace '(?:\r\n){2,}', "`r`n`r`n"

# Write to file
$result | Set-Content $cssFile -Encoding UTF8

$newSize = (Get-Item $cssFile).Length
Write-Host "Complete CSS formatting applied!"
Write-Host "Output size: $newSize bytes"
