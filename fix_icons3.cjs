const fs = require('fs');

const file = 'c:/xampp/htdocs/SiagaInd/resources/views/netral/index.blade.php';

const replacements = [
    {
        // "Lampu Minyak" Main Icon in info array
        pattern: /\['<i class="fa-solid fa-compass text-gray-600"><\/i>',\s*'Lampu Minyak'/g,
        replacement: "['<i class=\"fa-solid fa-lightbulb text-yellow-500\"></i>', 'Lampu Minyak'"
    },
    {
        // "Lampu Minyak" Main Icon in craftingData
        pattern: /'Lampu Minyak':\s*\{\s*icon:\s*'<i class="fa-solid fa-compass text-gray-600"><\/i>'/g,
        replacement: "'Lampu Minyak': {\n            icon: '<i class=\"fa-solid fa-lightbulb text-yellow-500\"></i>'"
    },
    {
        // "Minyak Goreng" in materials array
        pattern: /<i class="fa-solid fa-syringe text-gray-400"><\/i>(',?\s*'Minyak Goreng')/g,
        replacement: '<i class="fa-solid fa-bottle-droplet text-yellow-600\"></i>$1'
    },
    {
        pattern: /<i class="fa-solid fa-syringe text-gray-400"><\/i>(',?\s*n:\s*'Minyak Goreng')/g,
        replacement: '<i class="fa-solid fa-bottle-droplet text-yellow-600\"></i>$1'
    },
    {
        // "Minyak Jelantah" (was Minyak Bekas? Let's check what it was called)
        // Wait, looking at task-1930.log: "Minyak Bekas" had icon fa-paperclip
        pattern: /<i class="fa-solid fa-paperclip text-gray-500"><\/i>(',?\s*n:\s*'Minyak (Bekas|Jelantah)')/g,
        replacement: '<i class="fa-solid fa-bottle-droplet text-yellow-700\"></i>$1'
    },
    {
        // "Tisu" in Lampu Minyak (was fa-magnet)
        pattern: /<i class="fa-solid fa-magnet text-red-500"><\/i>(',?\s*'Tisu')/g,
        replacement: '<i class="fa-solid fa-toilet-paper text-white drop-shadow-md\"></i>$1'
    },
    {
        pattern: /<i class="fa-solid fa-magnet text-red-500"><\/i>(',?\s*n:\s*'Tisu')/g,
        replacement: '<i class="fa-solid fa-toilet-paper text-white drop-shadow-md\"></i>$1'
    },
    {
        // "Kapas" in Lampu Minyak (was fa-mitten)
        pattern: /<i class="fa-solid fa-mitten text-red-400"><\/i>(',?\s*n:\s*'Kapas')/g,
        replacement: '<i class="fa-solid fa-cloud text-gray-300\"></i>$1'
    },
    {
        // "Kaleng Belah" in Lampu Minyak (was fa-bowling-ball)
        pattern: /<i class="fa-solid fa-bowling-ball text-amber-800"><\/i>(',?\s*n:\s*'Kaleng Belah')/g,
        replacement: '<i class="fa-solid fa-jar text-gray-400\"></i>$1'
    }
];

if (fs.existsSync(file)) {
    let content = fs.readFileSync(file, 'utf8');

    for (const rule of replacements) {
        content = content.replace(rule.pattern, rule.replacement);
    }
    
    // Global generic replacement for specific texts just in case the regex missed it due to string formatting
    // Minyak Goreng
    content = content.replace(/i:\s*'<i class="[^"]+"><\/i>'\s*\}\s*(,\s*\{\s*n:\s*'Minyak Goreng')/g, "i: '<i class=\"fa-solid fa-bottle-droplet text-yellow-600\"></i>'} $1");
    // Tisu
    content = content.replace(/icon:\s*'<i class="[^"]+"><\/i>'\s*,\s*swappable:\s*true,\s*options:\s*\[\s*\{\s*n:\s*'Tisu'/g, "icon: '<i class=\"fa-solid fa-toilet-paper text-white drop-shadow-md\"></i>', swappable: true, options: [{n: 'Tisu'");
    content = content.replace(/i:\s*'<i class="[^"]+"><\/i>'\s*\}\s*,\s*\{\s*n:\s*'Tisu'/g, "i: '<i class=\"fa-solid fa-toilet-paper text-white drop-shadow-md\"></i>'}, {n: 'Tisu'");
    
    // Force direct replace string for Lampu Minyak materials to be 100% sure
    content = content.replace(/{ name: 'Minyak Goreng', role: 'Minyak', icon: '<i class="[^"]+"><\/i>', swappable: true, options: \[\{n: 'Minyak Goreng', i: '<i class="[^"]+"><\/i>'\}, \{n: 'Minyak Bekas', i: '<i class="[^"]+"><\/i>'\}\] \}/g, 
    "{ name: 'Minyak Goreng', role: 'Minyak', icon: '<i class=\"fa-solid fa-bottle-droplet text-yellow-600\"></i>', swappable: true, options: [{n: 'Minyak Goreng', i: '<i class=\"fa-solid fa-bottle-droplet text-yellow-600\"></i>'}, {n: 'Minyak Bekas', i: '<i class=\"fa-solid fa-oil-can text-yellow-700\"></i>'}] }");
    
    content = content.replace(/{ name: 'Tisu', role: 'Sumbu', icon: '<i class="[^"]+"><\/i>', swappable: true, options: \[\{n: 'Tisu', i: '<i class="[^"]+"><\/i>'\}, \{n: 'Kapas', i: '<i class="[^"]+"><\/i>'\}, \{n: 'Kain Perca', i: '<i class="[^"]+"><\/i>'\}\] \}/g, 
    "{ name: 'Tisu', role: 'Sumbu', icon: '<i class=\"fa-solid fa-toilet-paper text-white drop-shadow-md\"></i>', swappable: true, options: [{n: 'Tisu', i: '<i class=\"fa-solid fa-toilet-paper text-white drop-shadow-md\"></i>'}, {n: 'Kapas', i: '<i class=\"fa-solid fa-cloud text-gray-300\"></i>'}, {n: 'Kain Perca', i: '<i class=\"fa-solid fa-shirt text-orange-300\"></i>'}] }");
    
    content = content.replace(/{ name: 'Mangkuk Kecil', role: 'Wadah', icon: '<i class="[^"]+"><\/i>', swappable: true, options: \[\{n: 'Mangkuk Kecil', i: '<i class="[^"]+"><\/i>'\}, \{n: 'Gelas', i: '<i class="[^"]+"><\/i>'\}, \{n: 'Kaleng Belah', i: '<i class="[^"]+"><\/i>'\}\] \}/g, 
    "{ name: 'Mangkuk Kecil', role: 'Wadah', icon: '<i class=\"fa-solid fa-bowl-food text-orange-200\"></i>', swappable: true, options: [{n: 'Mangkuk Kecil', i: '<i class=\"fa-solid fa-bowl-food text-orange-200\"></i>'}, {n: 'Gelas', i: '<i class=\"fa-solid fa-glass-water text-blue-200\"></i>'}, {n: 'Kaleng Belah', i: '<i class=\"fa-solid fa-jar text-gray-400\"></i>'}] }");

    fs.writeFileSync(file, content, 'utf8');
    console.log(`Processed ${file}`);
}
