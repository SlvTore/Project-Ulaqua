// Centralized service data derived from template service detail pages
export const SERVICES = {
  'project-planning': {
    id: 'project-planning',
    title: 'Perencanaan ',
    icon: 'flaticon-water-bottle-1',
    heroImage: 'assets/images/resource/service-1.jpg',
    images: ['assets/images/resource/service-2.jpg','assets/images/resource/service-3.jpg'],
    short: 'Perencanaan profesional untuk proyek sistem air agar efisien dan sesuai standar.',
    sections: [
      { heading: 'Perencanaan Proyek', text: 'Kami menyediakan layanan perencanaan menyeluruh untuk instalasi pengolahan air, mulai dari analisis kebutuhan, desain sistem, kesesuaian regulasi, pengadaan, hingga optimasi jadwal pelaksanaan.' },
      { heading: 'Pendampingan Ahli', text: 'Tim kami mengandalkan pengalaman panjang untuk mengantisipasi risiko, mengoptimalkan alokasi sumber daya, dan mempercepat proses implementasi.' }
    ],
    features: [
      { title: 'Optimasi Jadwal', desc: 'Tahapan kerja yang terstruktur membantu mengurangi keterlambatan dan meningkatkan kepastian penyelesaian.' },
      { title: 'Siap Kepatuhan', desc: 'Dirancang sesuai pedoman keselamatan air tingkat lokal maupun internasional.' }
    ]
  },
  'residential-waters': {
    id: 'residential-waters',
    title: 'Air Rumah Tangga',
    icon: 'flaticon-water',
    heroImage: 'assets/images/resource/service-4.jpg',
    images: ['assets/images/resource/service-2.jpg','assets/images/resource/service-3.jpg'],
    short: 'Sistem pemurnian dan pelunakan air untuk kebutuhan seluruh rumah.',
    sections: [
      { heading: 'Air Rumah Tangga', text: 'Solusi pengolahan air rumah tangga kami membantu mengurangi sedimen, logam berat, mikroorganisme, klorin, dan tingkat kesadahan air.' },
      { heading: 'Sehat dan Nyaman', text: 'Air yang lebih bersih untuk minum, mandi, dan peralatan rumah tangga sehingga kualitas hidup meningkat dan usia pakai perangkat lebih panjang.' }
    ],
    features: [
      { title: 'Filtrasi Bertahap', desc: 'Integrasi filter sedimen, karbon aktif, RO, hingga UV untuk hasil lebih optimal.' },
      { title: 'Efisien dan Ramah Lingkungan', desc: 'Penggunaan air dan energi dioptimalkan agar lebih hemat.' }
    ]
  },
  'commercial-waters': {
    id: 'commercial-waters',
    title: 'Air Komersial',
    icon: 'flaticon-water-bottle',
    heroImage: 'assets/images/resource/service-5.jpg',
    images: ['assets/images/resource/service-2.jpg','assets/images/resource/service-3.jpg'],
    short: 'Sistem pengolahan air yang skalabel untuk hotel, ritel, dan perkantoran.',
    sections: [
      { heading: 'Air Komersial', text: 'Sistem dirancang khusus sesuai kebutuhan debit air, ketahanan operasional, dan efisiensi perawatan bisnis Anda.' },
      { heading: 'Keandalan Operasional', text: 'Pemantauan cerdas dan desain modular membantu meminimalkan downtime dalam operasional harian.' }
    ],
    features: [
      { title: 'Arsitektur Skalabel', desc: 'Konfigurasi modular memudahkan penyesuaian saat kebutuhan usaha berkembang.' },
      { title: 'Pemantauan Jarak Jauh', desc: 'Peringatan performa dan diagnostik dini membantu tindakan cepat.' }
    ]
  },
  'filtration-plants': {
    id: 'filtration-plants',
    title: 'Pabrik Filtrasi',
    icon: 'flaticon-recycle',
    heroImage: 'assets/images/resource/service-6.jpg',
    images: ['assets/images/resource/service-2.jpg','assets/images/resource/service-3.jpg'],
    short: 'Infrastruktur filtrasi skala besar untuk kebutuhan industri dan kawasan.',
    sections: [
      { heading: 'Pabrik Filtrasi', text: 'Kami menyediakan layanan desain dan pembangunan instalasi pemurnian air skala besar, termasuk klarifikasi, disinfeksi, dan pengolahan lumpur.' },
      { heading: 'Rekayasa Unggul', text: 'Pemodelan proses dilakukan untuk menjaga efisiensi, kapasitas produksi, dan keberlanjutan operasional.' }
    ],
    features: [
      { title: 'Pemodelan Proses', desc: 'Simulasi lanjutan membantu mengoptimalkan kapasitas dan alur produksi.' },
      { title: 'Dukungan Siklus Hidup', desc: 'Mencakup commissioning, pelatihan, audit, hingga peningkatan sistem.' }
    ]
  },
  'water-softening': {
    id: 'water-softening',
    title: 'Pemurnian Air',
    icon: 'flaticon-glass',
    heroImage: 'assets/images/resource/service-7.jpg',
    images: ['assets/images/resource/service-2.jpg','assets/images/resource/service-3.jpg'],
    short: 'Teknologi pertukaran ion dan metode lain untuk menurunkan kesadahan air.',
    sections: [
      { heading: 'Pelunakan Air', text: 'Membantu mengurangi kerak pada pipa dan peralatan sehingga efisiensi meningkat dan umur aset lebih panjang.' },
      { heading: 'Kualitas dan Kenyamanan', text: 'Penggunaan sabun lebih efektif, noda air berkurang, serta kulit dan rambut terasa lebih nyaman.' }
    ],
    features: [
      { title: 'Penggunaan Garam Rendah', desc: 'Siklus regenerasi dioptimalkan agar lebih hemat bahan.' },
      { title: 'Kontrol Cerdas', desc: 'Otomasi berbasis kebutuhan membantu mengurangi pemborosan.' }
    ]
  },
  'market-research': {
    id: 'market-research',
    title: 'Riset Pasar',
    icon: 'flaticon-water-drop',
    heroImage: 'assets/images/resource/service-8.jpg',
    images: ['assets/images/resource/service-2.jpg','assets/images/resource/service-3.jpg'],
    short: 'Wawasan analitis untuk strategi investasi dan pengembangan produk industri air.',
    sections: [
      { heading: 'Riset Pasar', text: 'Kajian berbasis data meliputi tren regulasi, perilaku konsumen, serta perkembangan teknologi terbaru di industri air.' },
      { heading: 'Kejelasan Strategis', text: 'Laporan yang dapat langsung ditindaklanjuti untuk alokasi modal dan perencanaan roadmap bisnis.' }
    ],
    features: [
      { title: 'Benchmarking', desc: 'Perbandingan performa kompetitif dan regional sebagai dasar evaluasi.' },
      { title: 'Prediksi Tren', desc: 'Pemodelan prediktif untuk membantu membaca arah pasar.' }
    ]
  }
};

// Ordered array for listings & navigation
export const SERVICES_ORDER = [
  'project-planning',
  'residential-waters',
  'commercial-waters',
  'filtration-plants',
  'water-softening',
  'market-research'
];

export const SERVICES_LIST = SERVICES_ORDER.map(k => {
  const { id, title, icon, short } = SERVICES[k];
  return { id, title, icon, description: short, link: `/service/${id}` };
});

