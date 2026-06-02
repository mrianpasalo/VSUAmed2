# Advanced CSS Formatter - Expands minified CSS with proper indentation
$cssFile = "c:\xampp\htdocs\VSUAmed2\assets\css\kaiadmin.min.css"
$content = Get-Content $cssFile -Raw

# Step 1: Fix spacing around braces and semicolons
$content = $content -replace '(\S)\{', "`$1 {`n"           # Add newline after opening brace content
$content = $content -replace '\}(\S)', "`}`n`$1"            # Add newline before closing brace content  
$content = $content -replace '(\S);(\S)', "`$1;`n`$2"       # Add newlines between properties

# Step 2: Split selectors on commas
$content = $content -replace ',([^\s])', ",`n`$1"

# Step 3: Split by lines and process
$lines = $content -split "`n" | Where-Object { $_.Trim() -ne "" }

$formatted = @()
$indentLevel = 0

foreach ($line in $lines) {
    $trimmed = $line.Trim()
    
    if ($trimmed -eq "") { continue }
    
    # Count braces to adjust indent
    $openBraces = ($trimmed | Select-String -Pattern '{' -AllMatches).Matches.Count
    $closeBraces = ($trimmed | Select-String -Pattern '}' -AllMatches).Matches.Count
    
    # Decrease indent for closing braces
    if ($closeBraces -gt 0) {
        $indentLevel = [Math]::Max(0, $indentLevel - $closeBraces)
    }
    
    # Apply indentation
    $indent = "  " * $indentLevel
    
    # Special handling: property lines should have extra indentation
    if ($trimmed -match ':\s*' -and -not ($trimmed -match '^[a-zA-Z0-9\-\.,#\[\]:\s]+\s*\{')) {
        $formatted += ($indent + "  " + $trimmed)
    } else {
        $formatted += ($indent + $trimmed)
    }
    
    # Increase indent for opening braces
    if ($openBraces -gt 0) {
        $indentLevel += $openBraces
    }
}

# Join and write
$result = $formatted -join "`r`n"

# Clean up multiple blank lines
$result = $result -replace '(?:\r\n){3,}', "`r`n`r`n"

$result | Set-Content $cssFile -Encoding UTF8 -NoNewline

Write-Host "CSS file formatted successfully!"
Write-Host "Original size: 214,737 bytes"
$newSize = (Get-Item $cssFile).Length
Write-Host "New size: $newSize bytes"
