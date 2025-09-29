<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة الجمعيات الخيرية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');
        
        body {
            font-family: 'Cairo', sans-serif;
        }
        
        .nav-shadow {
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        .hero-pattern {
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #059669 0%, #14b8a6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .icon-glow {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 text-gray-800">

    <!-- Navigation Bar -->
    <nav class="bg-white fixed w-full top-0 z-50 nav-shadow">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-hand-holding-heart text-green-600 text-3xl icon-glow"></i>
                    <span class="text-2xl font-bold gradient-text">نظام الجمعيات الخيرية</span>
                </div>
                
                <div class="flex items-center gap-6">
                    <a href="#features" class="text-gray-700 hover:text-green-600 transition font-semibold hidden md:block">
                        المميزات
                    </a>
                    <a href="#features" class="text-gray-700 hover:text-green-600 transition font-semibold hidden md:block">
                        عن النظام
                    </a>
                    <a href="#contact" class="text-gray-700 hover:text-green-600 transition font-semibold hidden md:block">
                        تواصل معنا
                    </a>
                    <a href="/login" class="bg-gradient-to-r from-green-600 to-teal-500 text-white px-6 py-2.5 rounded-lg font-bold hover:shadow-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>تسجيل الدخول</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-500 text-white hero-pattern mt-16">
        <div class="container mx-auto px-6 py-20 md:py-28">
            <div class="text-center max-w-4xl mx-auto">
                <div class="mb-6">
                    <i class="fa-solid fa-hand-holding-heart text-yellow-300 text-6xl md:text-7xl icon-glow animate-pulse"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">
                    نظام إدارة الجمعيات الخيرية
                </h1>
                <p class="text-xl md:text-2xl mb-10 leading-relaxed opacity-95">
                    منصة متكاملة وذكية لتسهيل إدارة المستفيدين والمساعدات وإصدار التقارير التفصيلية بكفاءة عالية
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/login" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-yellow-400 text-black font-bold rounded-xl shadow-xl hover:bg-yellow-500 hover:shadow-2xl transition transform hover:scale-105">
                        <i class="fa-solid fa-rocket text-xl"></i>
                        <span class="text-lg">ابدأ الآن</span>
                    </a>
                    <a href="#features" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-sm text-white font-bold rounded-xl border-2 border-white/40 hover:bg-white/30 transition transform hover:scale-105">
                        <i class="fa-solid fa-circle-info text-xl"></i>
                        <span class="text-lg">اعرف المزيد</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="container mx-auto px-6 py-20">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-black mb-4 gradient-text">
                💡 مميزات النظام
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                حلول شاملة ومتطورة لإدارة عمليات الجمعيات الخيرية بكل احترافية
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl border-t-4 border-green-500">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-users text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">إدارة المستفيدين</h3>
                <p class="text-gray-600 leading-relaxed">
                    نظام متقدم لتسجيل وإدارة بيانات المستفيدين وأسرهم مع إمكانيات بحث وفلترة قوية ومرنة
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl border-t-4 border-yellow-500">
                <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-hand-holding-dollar text-yellow-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">تسجيل المساعدات</h3>
                <p class="text-gray-600 leading-relaxed">
                    متابعة شاملة للمساعدات المالية والعينية مع ربط تلقائي بالمستفيدين والجمعيات والموظفين
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl border-t-4 border-blue-500">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-building text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">إدارة الجمعيات</h3>
                <p class="text-gray-600 leading-relaxed">
                    إدارة كاملة لبيانات الجمعيات الخيرية مع متابعة حالة النشاط والتواصل الفعال
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl border-t-4 border-purple-500">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-user-shield text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">صلاحيات متقدمة</h3>
                <p class="text-gray-600 leading-relaxed">
                    نظام أدوار وصلاحيات مرن (مدير - مستخدم - مشرف) لضمان الأمان والتحكم الكامل
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl border-t-4 border-indigo-500">
                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-chart-line text-indigo-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">تقارير ذكية</h3>
                <p class="text-gray-600 leading-relaxed">
                    لوحات تحكم تفاعلية وتقارير مفصلة مع رسوم بيانية وإحصائيات دقيقة لدعم اتخاذ القرار
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl border-t-4 border-pink-500">
                <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mb-5">
                    <i class="fa-solid fa-mobile-screen text-pink-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">تصميم متجاوب</h3>
                <p class="text-gray-600 leading-relaxed">
                    واجهة عصرية تعمل بسلاسة على جميع الأجهزة (الهواتف - التابلت - الكمبيوتر)
                </p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-gradient-to-r from-green-600 to-teal-500 py-16">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8 text-center text-white">
                <div class="p-6">
                    <div class="text-5xl font-black mb-2">500+</div>
                    <div class="text-xl opacity-90">جمعية خيرية</div>
                </div>
                <div class="p-6">
                    <div class="text-5xl font-black mb-2">10,000+</div>
                    <div class="text-xl opacity-90">مستفيد</div>
                </div>
                <div class="p-6">
                    <div class="text-5xl font-black mb-2">50,000+</div>
                    <div class="text-xl opacity-90">مساعدة مقدمة</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container mx-auto px-6 py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-black mb-6 gradient-text">
                📞 تواصل معنا
            </h2>
            <p class="text-gray-600 text-lg mb-12 leading-relaxed">
                هل تمثل جمعية خيرية؟ تواصل معنا للحصول على حساب والانضمام لمنصتنا
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <a href="mailto:info@charity-system.com" class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl block">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-envelope text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2">البريد الإلكتروني</h3>
                    <p class="text-gray-600">info@charity-system.com</p>
                </a>

                <a href="tel:01012345678" class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl block">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-phone text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2">الهاتف</h3>
                    <p class="text-gray-600" dir="ltr">010-1234-5678</p>
                </a>

                <a href="#" class="feature-card bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl block">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-brands fa-facebook text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-2">فيسبوك</h3>
                    <p class="text-gray-600">تابعنا على فيسبوك</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <i class="fa-solid fa-hand-holding-heart text-green-400 text-3xl"></i>
                    <span class="text-2xl font-bold">نظام إدارة الجمعيات الخيرية</span>
                </div>
                <p class="text-gray-400 mb-4">منصة متكاملة لإدارة الأعمال الخيرية بكفاءة واحترافية</p>
                <div class="flex justify-center gap-6 text-2xl mb-6">
                    <a href="#" class="text-gray-400 hover:text-green-400 transition">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-400 transition">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-400 transition">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                </div>
                <p class="text-gray-500 text-sm">© 2025 نظام إدارة الجمعيات الخيرية - جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>

</body>
</html>