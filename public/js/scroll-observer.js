// استخدام MutationObserver بدلاً من DOMNodeInserted
document.addEventListener('DOMContentLoaded', function() {
    // تكوين المراقب
    const config = { 
        childList: true, 
        subtree: true 
    };

    // إنشاء مراقب للتغييرات
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                // التحقق من إضافة عناصر جديدة
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // عنصر DOM
                        initializeScrollBehavior(node);
                    }
                });
            }
        });
    });

    // بدء المراقبة على جسم الصفحة
    observer.observe(document.body, config);

    // تهيئة سلوك التمرير للعناصر الموجودة
    function initializeScrollBehavior(element) {
        const scrollElements = element.querySelectorAll('[data-scroll]');
        scrollElements.forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // تهيئة العناصر الموجودة عند تحميل الصفحة
    initializeScrollBehavior(document.body);
});
