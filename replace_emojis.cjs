const fs = require('fs');

const emojiMap = {
    // Bencana & Alam
    '🌍': '<i class="fa-solid fa-earth-asia text-blue-600"></i>',
    '🌊': '<i class="fa-solid fa-water text-teal-600"></i>',
    '🌧️': '<i class="fa-solid fa-cloud-showers-heavy text-blue-400"></i>',
    '⛰️': '<i class="fa-solid fa-mountain text-amber-700"></i>',
    '🔥': '<i class="fa-solid fa-fire text-red-500"></i>',
    '🌪️': '<i class="fa-solid fa-tornado text-gray-500"></i>',
    '☀️': '<i class="fa-solid fa-sun text-yellow-500"></i>',
    '💧': '<i class="fa-solid fa-droplet text-blue-500"></i>',
    '🏞️': '<i class="fa-solid fa-water text-blue-300"></i>',
    '🏖️': '<i class="fa-solid fa-umbrella-beach text-yellow-500"></i>',
    '☁️': '<i class="fa-solid fa-cloud text-gray-300"></i>',
    '🍂': '<i class="fa-solid fa-leaf text-amber-500"></i>',
    '🌿': '<i class="fa-solid fa-leaf text-green-500"></i>',
    '🌳': '<i class="fa-solid fa-tree text-green-700"></i>',

    // Material Crafting / Survival
    '🧴': '<i class="fa-solid fa-bottle-water text-blue-300"></i>',
    '🫙': '<i class="fa-solid fa-jar text-gray-400"></i>',
    '🎋': '<i class="fa-solid fa-seedling text-green-500"></i>',
    '🥫': '<i class="fa-solid fa-bucket text-gray-500"></i>',
    '🟩': '<i class="fa-solid fa-square text-green-400"></i>',
    '🧻': '<i class="fa-solid fa-toilet-paper text-white drop-shadow-md"></i>',
    '🌸': '<i class="fa-solid fa-fan text-pink-300"></i>',
    '👕': '<i class="fa-solid fa-shirt text-blue-400"></i>',
    '🥥': '<i class="fa-solid fa-bowling-ball text-amber-800"></i>',
    '🪵': '<i class="fa-solid fa-tree text-amber-900"></i>',
    '🌾': '<i class="fa-solid fa-wheat-awn text-yellow-600"></i>',
    '🏗️': '<i class="fa-solid fa-trowel-bricks text-gray-500"></i>',
    '🪨': '<i class="fa-solid fa-hill-rockslide text-gray-600"></i>',
    '🧱': '<i class="fa-solid fa-brick text-red-700"></i>',
    '🫗': '<i class="fa-solid fa-glass-water text-blue-200"></i>',
    '🔪': '<i class="fa-solid fa-kitchen-set text-gray-400"></i>',
    '🪝': '<i class="fa-solid fa-anchor text-gray-600"></i>',
    '🔗': '<i class="fa-solid fa-link text-gray-500"></i>',
    '🧵': '<i class="fa-solid fa-tape text-blue-400"></i>',
    '🏷️': '<i class="fa-solid fa-tag text-gray-400"></i>',
    '🦯': '<i class="fa-solid fa-crutch text-gray-400"></i>',
    '🔋': '<i class="fa-solid fa-battery-full text-green-500"></i>',
    '⌚': '<i class="fa-solid fa-clock text-gray-600"></i>',
    '📱': '<i class="fa-solid fa-mobile-screen text-gray-700"></i>',
    '🍬': '<i class="fa-solid fa-candy-cane text-red-400"></i>',
    '🌯': '<i class="fa-solid fa-scroll text-gray-300"></i>',
    '💊': '<i class="fa-solid fa-pills text-red-500"></i>',
    '🧭': '<i class="fa-solid fa-compass text-gray-600"></i>',
    '🪡': '<i class="fa-solid fa-syringe text-gray-400"></i>',
    '🧷': '<i class="fa-solid fa-paperclip text-gray-500"></i>',
    '📎': '<i class="fa-solid fa-paperclip text-gray-500"></i>',
    '🪒': '<i class="fa-solid fa-scissors text-gray-400"></i>',
    '🧲': '<i class="fa-solid fa-magnet text-red-500"></i>',
    '🧣': '<i class="fa-solid fa-mitten text-red-400"></i>',
    '👱': '<i class="fa-solid fa-user text-yellow-500"></i>',
    '🔊': '<i class="fa-solid fa-volume-high text-gray-600"></i>',
    '🥡': '<i class="fa-solid fa-box text-white drop-shadow-md"></i>',
    '🍾': '<i class="fa-solid fa-wine-bottle text-green-700"></i>',
    '🥣': '<i class="fa-solid fa-bowl-food text-orange-200"></i>',
    '📦': '<i class="fa-solid fa-box-open text-amber-600"></i>',
    '🛁': '<i class="fa-solid fa-bath text-blue-200"></i>',
    '🧪': '<i class="fa-solid fa-flask text-purple-500"></i>',
    '🛍️': '<i class="fa-solid fa-bag-shopping text-pink-500"></i>',
    '🎽': '<i class="fa-solid fa-shirt text-gray-300"></i>',
    '🎗️': '<i class="fa-solid fa-ribbon text-yellow-500"></i>',
    '🧥': '<i class="fa-solid fa-vest text-orange-500"></i>',
    '🛌': '<i class="fa-solid fa-bed text-blue-400"></i>',
    '🔩': '<i class="fa-solid fa-screwdriver-wrench text-gray-500"></i>',
    '⛺': '<i class="fa-solid fa-tent text-green-600"></i>',
    '🥄': '<i class="fa-solid fa-spoon text-gray-400"></i>',
    '🍲': '<i class="fa-solid fa-bowl-food text-orange-400"></i>',

    // Medical & First Aid
    '🩹': '<i class="fa-solid fa-band-aid text-orange-300"></i>',
    '🩺': '<i class="fa-solid fa-stethoscope text-gray-700"></i>',
    '🩸': '<i class="fa-solid fa-droplet text-red-600"></i>',
    '🫁': '<i class="fa-solid fa-lungs text-pink-400"></i>',
    '💫': '<i class="fa-solid fa-star text-yellow-400"></i>',
    '🦴': '<i class="fa-solid fa-bone text-gray-300 drop-shadow-md"></i>',
    '🤕': '<i class="fa-solid fa-head-side-medical text-orange-400"></i>',
    '🗣️': '<i class="fa-solid fa-head-side-cough text-blue-500"></i>',
    '✋': '<i class="fa-solid fa-hand text-yellow-300"></i>',
    '🏃': '<i class="fa-solid fa-person-running text-green-500"></i>',
    '🛡️': '<i class="fa-solid fa-shield text-gray-500"></i>',
    '🚑': '<i class="fa-solid fa-truck-medical text-red-500"></i>',
    '🪢': '<i class="fa-solid fa-compress text-gray-400"></i>',
    '🧦': '<i class="fa-solid fa-socks text-orange-300"></i>',
    '❤️': '<i class="fa-solid fa-heart-pulse text-red-500"></i>',
    '🚰': '<i class="fa-solid fa-faucet-drip text-blue-400"></i>',
    '🛑': '<i class="fa-solid fa-ban text-red-600"></i>',
    '📐': '<i class="fa-solid fa-ruler-combined text-gray-500"></i>',
    '💪': '<i class="fa-solid fa-dumbbell text-gray-600"></i>',
    '🥻': '<i class="fa-solid fa-person-dress text-pink-400"></i>',

    // Utility
    '🛠️': '<i class="fa-solid fa-screwdriver-wrench text-gray-600"></i>',
    '📍': '<i class="fa-solid fa-location-dot text-red-500"></i>',
    '📞': '<i class="fa-solid fa-phone text-blue-500"></i>',
    '🚪': '<i class="fa-solid fa-door-open text-amber-800"></i>',
    '🎒': '<i class="fa-solid fa-backpack text-green-600"></i>',
    '📻': '<i class="fa-solid fa-radio text-gray-700"></i>',
    '🧯': '<i class="fa-solid fa-fire-extinguisher text-red-600"></i>',
    '🤝': '<i class="fa-solid fa-handshake text-yellow-600"></i>',
    '📄': '<i class="fa-solid fa-file-lines text-gray-400"></i>',
    '📸': '<i class="fa-solid fa-camera text-gray-700"></i>',
    '🔧': '<i class="fa-solid fa-wrench text-gray-500"></i>',
    '🗑️': '<i class="fa-solid fa-trash-can text-gray-400"></i>',
    '📢': '<i class="fa-solid fa-bullhorn text-red-400"></i>',
    '🧠': '<i class="fa-solid fa-brain text-pink-300"></i>',
    '📝': '<i class="fa-solid fa-clipboard-list text-gray-500"></i>',
    '⚡': '<i class="fa-solid fa-bolt text-yellow-400"></i>',
    '🏡': '<i class="fa-solid fa-house-chimney text-green-600"></i>',
    '⚠️': '<i class="fa-solid fa-triangle-exclamation text-amber-500"></i>'
};

const files = [
    'c:/xampp/htdocs/SiagaInd/resources/views/sebelum/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/saat/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/sesudah/index.blade.php',
    'c:/xampp/htdocs/SiagaInd/resources/views/netral/index.blade.php'
];

files.forEach(file => {
    if (!fs.existsSync(file)) return;
    let content = fs.readFileSync(file, 'utf8');

    // 1. Replace ALL Emojis
    // We sort keys by length descending (if there are multi-char emojis) to ensure correct replacement.
    const sortedEmojis = Object.keys(emojiMap).sort((a, b) => b.length - a.length);
    for (const emoji of sortedEmojis) {
        const faHtml = emojiMap[emoji];
        // Use a global replace for the emoji string
        content = content.split(emoji).join(faHtml);
    }

    // 2. HTML Templates x-text to x-html
    // Replace x-text="...icon..." or anything where an icon is bound to text.
    // e.g., x-text="step.icon" -> x-html="step.icon"
    // e.g., x-text="item.icon" -> x-html="item.icon"
    // e.g., x-text="tool.icon" -> x-html="tool.icon"
    content = content.replace(/x-text="([^"]*icon[^"]*)"/g, 'x-html="$1"');

    // Also replace in blade {{ $craft[0] }} to {!! $craft[0] !!} if it outputs HTML now
    // Wait, let's just make sure {{ $craft[0] }} and {{ $info[1] }} are outputting unescaped HTML!
    // In blade, {{ $b['icon'] }} escapes HTML. We need {!! $b['icon'] !!}
    content = content.replace(/\{\{\s*(\$b\['icon'\])\s*\}\}/g, '{!! $1 !!}');
    content = content.replace(/\{\{\s*(\$craft\[0\])\s*\}\}/g, '{!! $1 !!}');
    content = content.replace(/\{\{\s*(\$info\[0\])\s*\}\}/g, '{!! $1 !!}');
    
    // In Netral Blade, there's `['🌍', 'Gempa Bumi']`. We want the icon to render without escaping.
    // So `{!! $b['icon'] !!}` instead of `{{ $b['icon'] }}`.

    fs.writeFileSync(file, content, 'utf8');
    console.log(`Processed ${file}`);
});
