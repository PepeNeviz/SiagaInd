const fs = require('fs');

const files = [
    'c:/xampp/htdocs/SiagaInd/resources/views/sebelum/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/saat/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/sesudah/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/netral/index.blade.php'
];

// Re-mapping logic based on context rather than arbitrary text-replacement
const logicalReplacements = [
    {
        // "Membalut Luka" -> fa-bandage
        pattern: /<i class="fa-solid fa-bucket text-gray-500"><\/i>(',?\s*'Membalut Luka')/g,
        replacement: '<i class="fa-solid fa-bandage text-orange-300"></i>$1'
    },
    {
        // "Membalut Luka" inside inline array
        pattern: /<i class="fa-solid fa-bucket text-gray-500"><\/i>(',\s*'Membalut Luka')/g,
        replacement: '<i class="fa-solid fa-bandage text-orange-300"></i>$1'
    },
    {
        // "Membalut Luka" inside JS Object title
        pattern: /title:\s*'Membalut Luka',\s*icon:\s*'<i class="[^"]+"><\/i>'/g,
        replacement: "title: 'Membalut Luka',\n                icon: '<i class=\"fa-solid fa-bandage text-orange-300\"></i>'"
    },
    {
        // "Membalut Luka" info array netral
        pattern: /\['<i class="fa-solid fa-bucket[^>]+><\/i>',\s*'Membalut Luka'/g,
        replacement: "['<i class=\"fa-solid fa-bandage text-orange-300\"></i>', 'Membalut Luka'"
    },
    {
        // "Kain Penyangga Tangan" info array netral (was 🪢 -> fa-compress)
        pattern: /\['<i class="fa-solid fa-compress[^>]+><\/i>',\s*'Kain Penyangga Tangan'/g,
        replacement: "['<i class=\"fa-solid fa-mitten text-red-400\"></i>', 'Kain Penyangga Tangan'"
    },
    {
        // "Jam Matahari" info array netral (was 🧭 -> fa-compass)
        pattern: /\['<i class="fa-solid fa-compass[^>]+><\/i>',\s*'Jam Matahari'/g,
        replacement: "['<i class=\"fa-solid fa-clock text-gray-600\"></i>', 'Jam Matahari'"
    },
    {
        // "Menentukan Keamanan Air" info array netral (was ☀️ -> fa-sun)
        pattern: /\['<i class="fa-solid fa-sun[^>]+><\/i>',\s*'Menentukan Keamanan Air'/g,
        replacement: "['<i class=\"fa-solid fa-glass-water-droplet text-blue-400\"></i>', 'Menentukan Keamanan Air'"
    }
];

files.forEach(file => {
    if (!fs.existsSync(file)) return;
    let content = fs.readFileSync(file, 'utf8');

    // 1. Fix x-text vs x-html specifically for icon fields and name fields
    
    // Convert missing icon properties to x-html
    content = content.replace(/x-text="modalData\.steps\[injuryStepIndex\]\.i"/g, 'x-html="modalData.steps[injuryStepIndex].i"');
    content = content.replace(/x-text="i"/g, 'x-text="i"'); // keep `i` variable (like currentStep = i)
    // Wait, the button step numbers: <button x-text="i + 1"> should REMAIN x-text!
    // But `step.i` inside Alpine loops is the icon: <div x-text="step.i"> -> <div x-html="step.i">
    content = content.replace(/x-text="step\.i"/g, 'x-html="step.i"');
    content = content.replace(/x-text="step\.icon"/g, 'x-html="step.icon"');
    content = content.replace(/x-text="item\.icon"/g, 'x-html="item.icon"');
    content = content.replace(/x-text="tool\.icon"/g, 'x-html="tool.icon"');
    content = content.replace(/x-text="m\.icon"/g, 'x-html="m.icon"');
    content = content.replace(/x-text="choice\.icon"/g, 'x-html="choice.icon"');
    content = content.replace(/x-text="currentContent\.icon"/g, 'x-html="currentContent.icon"');
    content = content.replace(/x-text="modalData\.icon"/g, 'x-html="modalData.icon"');
    content = content.replace(/x-text="modalData\.tools\[currentToolIndex\]\.icon"/g, 'x-html="modalData.tools[currentToolIndex].icon"');
    content = content.replace(/x-text="\(modalData\.stepVisuals && modalData\.stepVisuals\[injuryStepIndex\]\) \? modalData\.stepVisuals\[injuryStepIndex\] \: modalData\.icon"/g, 'x-html="(modalData.stepVisuals && modalData.stepVisuals[injuryStepIndex]) ? modalData.stepVisuals[injuryStepIndex] : modalData.icon"');

    // Revert accidentally changed name/title properties back to x-text
    content = content.replace(/x-html="modalData\.title"/g, 'x-text="modalData.title"');
    content = content.replace(/x-html="modalData\.tools\[currentToolIndex\]\.name"/g, 'x-text="modalData.tools[currentToolIndex].name"');
    content = content.replace(/x-html="item\.name"/g, 'x-text="item.name"');
    content = content.replace(/x-html="item\.title"/g, 'x-text="item.title"');
    content = content.replace(/x-html="step\.d"/g, 'x-text="step.d"');
    content = content.replace(/x-html="m\.name"/g, 'x-text="m.name"');
    content = content.replace(/x-html="m\.role"/g, 'x-text="m.role"');

    // 2. Fix the illogical icons via regex
    for (const rule of logicalReplacements) {
        content = content.replace(rule.pattern, rule.replacement);
    }
    
    // Also let's fix any bucket icons mapped incorrectly
    content = content.replace(/<i class="fa-solid fa-bucket text-gray-500"><\/i>/g, '<i class="fa-solid fa-box text-gray-500"></i>');

    fs.writeFileSync(file, content, 'utf8');
    console.log(`Processed ${file}`);
});
