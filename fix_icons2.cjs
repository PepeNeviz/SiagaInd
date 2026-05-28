const fs = require('fs');

const files = [
    'c:/xampp/htdocs/SiagaInd/resources/views/sebelum/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/saat/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/sesudah/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/netral/index.blade.php'
];

const logicalReplacements = [
    {
        // "Pisau" -> fa-utensils (since standard fontawesome free doesn't have knife, utensils works, or trowel)
        pattern: /<i class="[^"]+"><\/i>(',?\s*'Pisau')/g,
        replacement: '<i class="fa-solid fa-utensils text-gray-500"></i>$1'
    },
    {
        // "Pisau" in title inside object
        pattern: /title:\s*'Pisau',\s*icon:\s*'<i class="[^"]+"><\/i>'/g,
        replacement: "title: 'Pisau',\n                icon: '<i class=\"fa-solid fa-utensils text-gray-500\"></i>'"
    },
    {
        // "Pisau" in info array
        pattern: /\['<i class="[^"]+"><\/i>',\s*'Pisau'/g,
        replacement: "['<i class=\"fa-solid fa-utensils text-gray-500\"></i>', 'Pisau'"
    },
    {
        pattern: /'Pisau':\s*\{\s*icon:\s*'<i class="[^"]+"><\/i>'/g,
        replacement: "'Pisau': {\n            icon: '<i class=\"fa-solid fa-utensils text-gray-500\"></i>'"
    },
    {
        // "Filter Air" -> fa-bottle-water or fa-filter
        pattern: /'Filter Air':\s*\{\s*icon:\s*'<i class="[^"]+"><\/i>'/g,
        replacement: "'Filter Air': {\n            icon: '<i class=\"fa-solid fa-filter text-blue-400\"></i>'"
    },
    {
        // "Korek Darurat" -> fa-fire-burner
        pattern: /'Korek Darurat':\s*\{\s*icon:\s*'<i class="[^"]+"><\/i>'/g,
        replacement: "'Korek Darurat': {\n            icon: '<i class=\"fa-solid fa-fire-burner text-orange-500\"></i>'"
    },
    {
        // "Kompas Sederhana" -> fa-compass
        pattern: /'Kompas Sederhana':\s*\{\s*icon:\s*'<i class="[^"]+"><\/i>'/g,
        replacement: "'Kompas Sederhana': {\n            icon: '<i class=\"fa-solid fa-compass text-gray-600\"></i>'"
    }
];

files.forEach(file => {
    if (!fs.existsSync(file)) return;
    let content = fs.readFileSync(file, 'utf8');

    // Fix remaining x-text
    content = content.replace(/x-text="toolIcon"/g, 'x-html="toolIcon"');
    content = content.replace(/x-text="icon"/g, 'x-html="icon"');
    content = content.replace(/x-text="m\.icon"/g, 'x-html="m.icon"'); // just in case!
    
    // Some loops might use x-text="step.icon" or x-text="item.icon" that got missed
    content = content.replace(/x-text="item\.icon"/g, 'x-html="item.icon"');
    content = content.replace(/x-text="craft\.icon"/g, 'x-html="craft.icon"');

    // Apply logical icon replacements
    for (const rule of logicalReplacements) {
        content = content.replace(rule.pattern, rule.replacement);
    }
    
    // Also let's check for any missing info array replacements for Korek / Kompas / Filter in netral inline arrays
    content = content.replace(/\['<i class="[^"]+"><\/i>',\s*'Korek Darurat'/g, "['<i class=\"fa-solid fa-fire-burner text-orange-500\"></i>', 'Korek Darurat'");
    content = content.replace(/\['<i class="[^"]+"><\/i>',\s*'Kompas Sederhana'/g, "['<i class=\"fa-solid fa-compass text-gray-600\"></i>', 'Kompas Sederhana'");
    content = content.replace(/\['<i class="[^"]+"><\/i>',\s*'Filter Air'/g, "['<i class=\"fa-solid fa-filter text-blue-400\"></i>', 'Filter Air'");

    fs.writeFileSync(file, content, 'utf8');
    console.log(`Processed ${file}`);
});
