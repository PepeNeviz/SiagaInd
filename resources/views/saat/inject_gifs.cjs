const fs = require('fs');
const file = 'c:/xampp/htdocs/SiagaInd/resources/views/saat/index.blade.php';
let content = fs.readFileSync(file, 'utf8');

// 1. UPDATE THE HTML TEMPLATE
// We insert the img tag just above <h3 ... x-text="choice.desc"></h3>
const htmlTarget = '<h3 class="font-bold text-sm md:text-lg text-gray-800 text-center w-full leading-tight" x-text="choice.desc"></h3>';
const userRequestedImg = `<img x-show="choice.gif" :src="'{{ asset(\\'\\') }}' + choice.gif" alt="Animasi Penyelamatan" class="w-full h-auto rounded-lg mb-4 object-cover">`;

if (!content.includes('x-show="choice.gif"')) {
    content = content.replace(htmlTarget, userRequestedImg + '\\n                                ' + htmlTarget);
}

// 2. UPDATE THE ALPINE DATA FOR GEMPA BUMI

const replacements = [
    // Step 1
    {
        oldStr: "{ label:'Luar Ruangan', icon:'<i class=\"fa-solid fa-tree text-green-700\"></i>', desc:'Jauhi benda rawan jatuh.' }",
        newStr: "{ label:'Luar Ruangan', icon:'<i class=\"fa-solid fa-tree text-green-700\"></i>', desc:'Jauhi benda rawan jatuh.', gif:'assets/gifs/gempa/Fall.gif' }"
    },
    {
        oldStr: "{ label:'Dalam Ruangan', icon:'<i class=\"fa-solid fa-house text-green-700\"></i>', desc:'Lindungi kepala.' }",
        newStr: "{ label:'Dalam Ruangan', icon:'<i class=\"fa-solid fa-house text-green-700\"></i>', desc:'Lindungi kepala.', gif:'assets/gifs/gempa/Hide & Grab.gif' }"
    },
    // Step 2
    {
        oldStr: "{ label:'Sendiri', icon:'<i class=\"fa-solid fa-person text-gray-700\"></i>', desc:'Fokus evakuasi diri.' }",
        newStr: "{ label:'Sendiri', icon:'<i class=\"fa-solid fa-person text-gray-700\"></i>', desc:'Fokus evakuasi diri.', gif:'assets/gifs/gempa/Run.gif' }"
    },
    {
        oldStr: "{ label:'Bersama Orang', icon:'<i class=\"fa-solid fa-people-group text-blue-600\"></i>', desc:'Bantu kelompok.' }",
        newStr: "{ label:'Bersama Orang', icon:'<i class=\"fa-solid fa-people-group text-blue-600\"></i>', desc:'Bantu kelompok.', gif:'assets/gifs/gempa/Gathering.gif' }"
    },
    // Step 3
    {
        oldStr: "{ label:'Ada', icon:'<i class=\"fa-solid fa-child-reaching text-orange-500\"></i>', desc:'Bantu lebih dulu.' }",
        newStr: "{ label:'Ada', icon:'<i class=\"fa-solid fa-child-reaching text-orange-500\"></i>', desc:'Bantu lebih dulu.', gif:'assets/gifs/gempa/Child.gif' }"
    },
    {
        oldStr: "{ label:'Tidak Ada', icon:'<i class=\"fa-solid fa-thumbs-up text-green-500\"></i>', desc:'Lanjut evakuasi.' }",
        newStr: "{ label:'Tidak Ada', icon:'<i class=\"fa-solid fa-thumbs-up text-green-500\"></i>', desc:'Lanjut evakuasi.', gif:'assets/gifs/gempa/Run.gif' }"
    },
    // Step 4
    {
        oldStr: "{ label:'Terbuka', icon:'<i class=\"fa-solid fa-door-open text-amber-800\"></i>', desc:'Segera keluar.' }",
        newStr: "{ label:'Terbuka', icon:'<i class=\"fa-solid fa-door-open text-amber-800\"></i>', desc:'Segera keluar.', gif:'assets/gifs/gempa/Evakuate.gif' }"
    },
    {
        oldStr: "{ label:'Tertutup', icon:'<i class=\"fa-solid fa-hill-rockslide text-gray-600\"></i>', desc:'Cari jalur alternatif.' }",
        newStr: "{ label:'Tertutup', icon:'<i class=\"fa-solid fa-hill-rockslide text-gray-600\"></i>', desc:'Cari jalur alternatif.', gif:'assets/gifs/gempa/Alternate.gif' }"
    },
    // Step 5
    {
        oldStr: "{ label:'Ada', icon:'<i class=\"fa-solid fa-fire text-red-500\"></i>', desc:'Jauhi area.' }",
        newStr: "{ label:'Ada', icon:'<i class=\"fa-solid fa-fire text-red-500\"></i>', desc:'Jauhi area.', gif:'assets/gifs/gempa/Fire.gif' }"
    },
    {
        oldStr: "{ label:'Tidak', icon:'<i class=\"fa-solid fa-circle-check text-green-500\"></i>', desc:'Lanjut aman.' }",
        newStr: "{ label:'Tidak', icon:'<i class=\"fa-solid fa-circle-check text-green-500\"></i>', desc:'Lanjut aman.', gif:'assets/gifs/gempa/Evakuate.gif' }"
    },
    // Step 6
    {
        oldStr: "{ label:'Ikuti Jalur', icon:'<i class=\"fa-solid fa-arrow-right text-blue-500\"></i>', desc:'Tetap tenang.' }",
        newStr: "{ label:'Ikuti Jalur', icon:'<i class=\"fa-solid fa-arrow-right text-blue-500\"></i>', desc:'Tetap tenang.', gif:'assets/gifs/gempa/Follow.gif' }"
    },
    {
        oldStr: "{ label:'Cari Jalur', icon:'<i class=\"fa-solid fa-compass text-gray-600\"></i>', desc:'Gunakan area terbuka.' }",
        newStr: "{ label:'Cari Jalur', icon:'<i class=\"fa-solid fa-compass text-gray-600\"></i>', desc:'Gunakan area terbuka.', gif:'assets/gifs/gempa/Open.gif' }"
    },
    // Step 7
    {
        oldStr: "{ label:'Sudah', icon:'<i class=\"fa-solid fa-tent text-green-600\"></i>', desc:'Tetap di shelter.' }",
        newStr: "{ label:'Sudah', icon:'<i class=\"fa-solid fa-tent text-green-600\"></i>', desc:'Tetap di shelter.', gif:'assets/gifs/gempa/Shelter.gif' }"
    },
    {
        oldStr: "{ label:'Belum', icon:'<i class=\"fa-solid fa-triangle-exclamation text-amber-500\"></i>', desc:'Cari tempat lain.' }",
        newStr: "{ label:'Belum', icon:'<i class=\"fa-solid fa-triangle-exclamation text-amber-500\"></i>', desc:'Cari tempat lain.', gif:'assets/gifs/gempa/Crack.gif' }"
    },
    // Step 8
    {
        oldStr: "{ label:'Lanjut', icon:'<i class=\"fa-solid fa-circle-check text-green-500\"></i>', desc:'Periksa kondisi tubuh.' }",
        newStr: "{ label:'Lanjut', icon:'<i class=\"fa-solid fa-circle-check text-green-500\"></i>', desc:'Periksa kondisi tubuh.', gif:'assets/gifs/gempa/Save.gif' }"
    }
];

let notFound = [];
for (const rep of replacements) {
    if (content.includes(rep.oldStr)) {
        content = content.replace(rep.oldStr, rep.newStr);
    } else {
        notFound.push(rep.oldStr);
    }
}

if (notFound.length > 0) {
    console.error("Some replacements were not found:");
    notFound.forEach(s => console.error(s));
} else {
    fs.writeFileSync(file, content);
    console.log("Successfully updated all GIFs and injected the HTML template.");
}
