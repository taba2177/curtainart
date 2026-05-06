import{i as w,A as v,S as M,s as d,ɵ as y,R as k,a as n,b as l,c as _,d as t,e as i,f as b,g as a,h as u,j as f,k as C,l as z,m as S,n as A,o as L,p as m,q as T,r as c,t as j,u as P}from"./main-CV8gYigs.js";import{S as H}from"./stats-counter.component-C6My9UmI.js";const I=["productSwiper"],E=()=>[1,2,3,4,5,6],x=(r,e)=>e.id;function F(r,e){r&1&&(n(0,"div",2),_(1,"div",22),t())}function Q(r,e){if(r&1&&(n(0,"section",3),_(1,"div",23)(2,"div",24),n(3,"div",25)(4,"h1",26),i(5),t(),n(6,"p",27),i(7),t(),n(8,"div",28)(9,"a",29),i(10,"احجز زيارة مجانية"),t(),n(11,"a",30),i(12,"تصفح منتجاتنا"),t()()()()),r&2){const o=e,s=m();a(),T("background-image","url(/images/curtainsart/hero/hero-main.jpg)"),a(4),c(s.getAr(o.title)),a(2),c(s.getAr(o.content))}}function R(r,e){if(r&1&&(n(0,"section",6)(1,"div",31)(2,"div",32)(3,"h2"),i(4),t(),n(5,"p"),i(6),t(),n(7,"a",33),i(8,"اعرف أكثر"),t()(),n(9,"div",34),_(10,"img",35),t()()()),r&2){const o=m();a(4),c(o.getAr(o.aboutPosts()[0].title)),a(2),c(o.getAr(o.aboutPosts()[0].content)),a(4),f("src",o.getImage(o.aboutPosts()[0].images),P)}}function $(r,e){if(r&1&&(n(0,"div",38)(1,"span",39),i(2,"✦"),t(),n(3,"h3"),i(4),t(),n(5,"p"),i(6),t()()),r&2){const o=e.$implicit,s=m(2);a(4),c(s.getAr(o.title)),a(2),c(s.getAr(o.excerpt))}}function q(r,e){if(r&1&&(n(0,"section",7)(1,"h2",36),i(2,"خدماتنا"),t(),n(3,"div",37),b(4,$,7,2,"div",38,x),t()()),r&2){const o=m();a(4),C(o.servicePosts())}}function B(r,e){if(r&1&&(n(0,"div",42)(1,"div",46),_(2,"img",47),t(),n(3,"h3"),i(4),t(),n(5,"p"),i(6),t()()),r&2){const o=e.$implicit,s=m(2);a(2),f("src",s.getImage(o.images),P)("alt",s.getAr(o.title)),a(2),c(s.getAr(o.title)),a(2),c(s.getAr(o.excerpt))}}function U(r,e){if(r&1&&(n(0,"section",8)(1,"h2",36),i(2,"منتجاتنا"),t(),n(3,"div",40,0)(5,"div",41),b(6,B,7,4,"div",42,x),t(),_(8,"div",43)(9,"div",44)(10,"div",45),t()()),r&2){const o=m();a(6),C(o.productPosts())}}function V(r,e){r&1&&_(0,"div",17)}class h{api=w(v);settings=w(M);productSwiperEl;isLoading=d(!0);heroPost=d(null);aboutPosts=d([]);servicePosts=d([]);productPosts=d([]);stats=d([]);whatsappLink=d("https://wa.me/966554373327");swiperInitialized=!1;ngOnInit(){this.api.home().subscribe({next:e=>{const o=e.sections.find(g=>g.section_component==="hero");this.heroPost.set(o?.posts?.[0]??null);const s=e.sections.find(g=>g.section_component==="about");this.aboutPosts.set(s?.posts??[]);const p=e.sections.find(g=>g.section_component==="services");this.servicePosts.set(p?.posts??[]);const O=e.sections.find(g=>g.section_component==="products-carousel");this.productPosts.set(O?.posts??[]),this.stats.set(this.parseStats()),this.whatsappLink.set(this.settings.get("cta_whatsapp_link","https://wa.me/966554373327")),this.isLoading.set(!1),this.initSwiper()},error:()=>this.isLoading.set(!1)})}ngAfterViewInit(){this.initSwiper()}initSwiper(){if(this.swiperInitialized||!this.productSwiperEl)return;const e=window.Swiper;e&&(new e(this.productSwiperEl.nativeElement,{slidesPerView:"auto",spaceBetween:24,pagination:{el:".swiper-pagination",clickable:!0}}),this.swiperInitialized=!0)}parseStats(){const e=this.settings.getStats();return e.length?e:[{value:900,label:"مشروع منجز",suffix:"+"},{value:2e3,label:"عميل موثوق",suffix:"+"},{value:47,label:"جهة حكومية",suffix:"+"},{value:10,label:"سنوات خبرة",suffix:"+"}]}getAr(e){return typeof e=="object"?e.ar??e.en??"":e??""}getImage(e){return(Array.isArray(e)?e:[])[0]??""}static ɵfac=function(o){return new(o||h)};static ɵcmp=y({type:h,selectors:[["app-home"]],viewQuery:function(o,s){if(o&1&&S(I,5),o&2){let p;A(p=L())&&(s.productSwiperEl=p.first)}},decls:49,vars:8,consts:[["productSwiper",""],["dir","rtl",1,"home"],[1,"home__loading"],[1,"hero"],[1,"stats-section"],[3,"stats"],[1,"about-preview"],[1,"services-section"],[1,"products-section"],[1,"why-us"],[1,"section-title","section-title--light"],[1,"why-us__grid"],[1,"why-card"],[1,"why-card__icon"],[1,"trust-strip"],[1,"trust-strip__heading"],[1,"trust-strip__logos"],[1,"trust-strip__placeholder"],[1,"cta-section"],[1,"cta-section__buttons"],["target","_blank","rel","noopener",1,"btn","btn--whatsapp",3,"href"],["routerLink","/contact",1,"btn","btn--outline-light"],[1,"spinner"],[1,"hero__bg"],[1,"hero__overlay"],[1,"hero__content"],[1,"hero__title"],[1,"hero__tagline"],[1,"hero__ctas"],["routerLink","/contact",1,"btn","btn--primary"],["routerLink","/products",1,"btn","btn--outline"],[1,"about-preview__inner"],[1,"about-preview__text"],["routerLink","/about",1,"btn","btn--primary"],[1,"about-preview__image"],["alt","من نحن","loading","lazy",3,"src"],[1,"section-title"],[1,"services-grid"],[1,"service-card"],[1,"service-card__icon"],[1,"swiper","products-swiper"],[1,"swiper-wrapper"],[1,"swiper-slide","product-card"],[1,"swiper-pagination"],[1,"swiper-button-next"],[1,"swiper-button-prev"],[1,"product-card__img-wrap"],["loading","lazy",3,"src","alt"]],template:function(o,s){if(o&1&&(n(0,"div",1),l(1,F,2,0,"div",2),l(2,Q,13,4,"section",3),n(3,"section",4),_(4,"app-stats-counter",5),t(),l(5,R,11,3,"section",6),l(6,q,6,0,"section",7),l(7,U,11,0,"section",8),n(8,"section",9)(9,"h2",10),i(10,"لماذا تختار مصنع فن الستارة؟"),t(),n(11,"div",11)(12,"div",12)(13,"span",13),i(14,"★"),t(),n(15,"h3"),i(16,"جودة عالية"),t(),n(17,"p"),i(18,"أفضل الخامات وأدق معايير الإنتاج"),t()(),n(19,"div",12)(20,"span",13),i(21,"﹩"),t(),n(22,"h3"),i(23,"أسعار تنافسية"),t(),n(24,"p"),i(25,"أفضل جودة بأسعار مناسبة لجميع الميزانيات"),t()(),n(26,"div",12)(27,"span",13),i(28,"✓"),t(),n(29,"h3"),i(30,"ضمان شامل"),t(),n(31,"p"),i(32,"ضمان على جميع منتجاتنا وخدماتنا"),t()()()(),n(33,"section",14)(34,"p",15),i(35,"+47 جهة حكومية تثق بنا"),t(),n(36,"div",16),b(37,V,1,0,"div",17,j),t()(),n(39,"section",18)(40,"h2"),i(41,"هل أنت مستعد لتحويل منزلك؟"),t(),n(42,"p"),i(43,"تواصل معنا الآن للحصول على استشارة مجانية وعرض سعر"),t(),n(44,"div",19)(45,"a",20),i(46," تواصل عبر واتساب "),t(),n(47,"a",21),i(48,"أرسل رسالة"),t()()()()),o&2){let p;a(),u(s.isLoading()?1:-1),a(),u((p=s.heroPost())?2:-1,p),a(2),f("stats",s.stats()),a(),u(s.aboutPosts().length?5:-1),a(),u(s.servicePosts().length?6:-1),a(),u(s.productPosts().length?7:-1),a(30),C(z(7,E)),a(8),f("href",s.whatsappLink(),P)}},dependencies:[k,H],styles:[`@charset "UTF-8";
.home[_ngcontent-%COMP%] {
  overflow-x: hidden;
}

.home__loading[_ngcontent-%COMP%] {
  display: flex;
  justify-content: center;
  padding: 4rem;
}
.home__loading[_ngcontent-%COMP%]   .spinner[_ngcontent-%COMP%] {
  width: 40px;
  height: 40px;
  border: 4px solid #e2f0fb;
  border-top-color: #0074b3;
  border-radius: 50%;
  animation: _ngcontent-%COMP%_spin 0.8s linear infinite;
}

@keyframes _ngcontent-%COMP%_spin {
  to {
    transform: rotate(360deg);
  }
}


.hero[_ngcontent-%COMP%] {
  position: relative;
  min-height: 90vh;
  display: flex;
  align-items: center;
  overflow: hidden;
}
.hero__bg[_ngcontent-%COMP%] {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  transform: scale(1.05);
  transition: transform 8s ease;
}
.hero__overlay[_ngcontent-%COMP%] {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(0, 116, 179, 0.9) 0%, rgba(0, 90, 142, 0.75) 100%);
}
.hero__content[_ngcontent-%COMP%] {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem 1.5rem;
  text-align: center;
  color: #fff;
}
.hero__title[_ngcontent-%COMP%] {
  font-size: clamp(2rem, 5vw, 3.5rem);
  font-weight: 700;
  margin-bottom: 1rem;
}
.hero__tagline[_ngcontent-%COMP%] {
  font-size: clamp(1rem, 2.5vw, 1.25rem);
  opacity: 0.9;
  margin-bottom: 2rem;
}
.hero__ctas[_ngcontent-%COMP%] {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}



.btn[_ngcontent-%COMP%] {
  display: inline-block;
  padding: 0.75rem 1.75rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  text-decoration: none;
  transition: all 0.2s;
}
.btn--primary[_ngcontent-%COMP%] {
  background: #0074b3;
  color: #fff;
}
.btn--primary[_ngcontent-%COMP%]:hover {
  background: #005a8e;
}
.btn--outline[_ngcontent-%COMP%] {
  border: 2px solid #fff;
  color: #fff;
}
.btn--outline[_ngcontent-%COMP%]:hover {
  background: #fff;
  color: #0074b3;
}
.btn--outline-light[_ngcontent-%COMP%] {
  border: 2px solid rgba(255, 255, 255, 0.6);
  color: #fff;
}
.btn--outline-light[_ngcontent-%COMP%]:hover {
  background: rgba(255, 255, 255, 0.1);
}
.btn--whatsapp[_ngcontent-%COMP%] {
  background: #25d366;
  color: #fff;
}
.btn--whatsapp[_ngcontent-%COMP%]:hover {
  background: #1da851;
}



.stats-section[_ngcontent-%COMP%] {
  background: #f0f7fc;
  padding: 3rem 1.5rem;
}
.stats-section[_ngcontent-%COMP%]   .stats-grid[_ngcontent-%COMP%] {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
  max-width: 1200px;
  margin: 0 auto;
}
@media (max-width: 768px) {
  .stats-section[_ngcontent-%COMP%]   .stats-grid[_ngcontent-%COMP%] {
    grid-template-columns: repeat(2, 1fr);
  }
}
.stats-section[_ngcontent-%COMP%]   .stat-card[_ngcontent-%COMP%] {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1.5rem;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 116, 179, 0.08);
}
.stats-section[_ngcontent-%COMP%]   .stat-value[_ngcontent-%COMP%] {
  font-size: 2.5rem;
  font-weight: 700;
  color: #0074b3;
}
.stats-section[_ngcontent-%COMP%]   .stat-label[_ngcontent-%COMP%] {
  color: #555;
  font-size: 0.9rem;
  margin-top: 0.25rem;
}



.section-title[_ngcontent-%COMP%] {
  text-align: center;
  font-size: 2rem;
  font-weight: 700;
  color: #1a2940;
  margin-bottom: 2rem;
}
.section-title--light[_ngcontent-%COMP%] {
  color: #fff;
}



.about-preview[_ngcontent-%COMP%] {
  padding: 4rem 1.5rem;
}
.about-preview__inner[_ngcontent-%COMP%] {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  align-items: center;
}
@media (max-width: 768px) {
  .about-preview__inner[_ngcontent-%COMP%] {
    grid-template-columns: 1fr;
  }
}
.about-preview[_ngcontent-%COMP%]   h2[_ngcontent-%COMP%] {
  font-size: 1.75rem;
  color: #1a2940;
  margin-bottom: 1rem;
}
.about-preview[_ngcontent-%COMP%]   p[_ngcontent-%COMP%] {
  color: #555;
  line-height: 1.8;
  margin-bottom: 1.5rem;
}
.about-preview__image[_ngcontent-%COMP%]   img[_ngcontent-%COMP%] {
  width: 100%;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}



.services-section[_ngcontent-%COMP%] {
  background: #f0f7fc;
  padding: 4rem 1.5rem;
}
.services-section[_ngcontent-%COMP%]   .services-grid[_ngcontent-%COMP%] {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
  max-width: 1200px;
  margin: 0 auto;
}
@media (max-width: 1024px) {
  .services-section[_ngcontent-%COMP%]   .services-grid[_ngcontent-%COMP%] {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (max-width: 600px) {
  .services-section[_ngcontent-%COMP%]   .services-grid[_ngcontent-%COMP%] {
    grid-template-columns: 1fr;
  }
}

.service-card[_ngcontent-%COMP%] {
  background: #fff;
  padding: 2rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 116, 179, 0.08);
  text-align: center;
  transition: transform 0.2s, box-shadow 0.2s;
}
.service-card[_ngcontent-%COMP%]:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0, 116, 179, 0.15);
}
.service-card__icon[_ngcontent-%COMP%] {
  font-size: 2rem;
  color: #0074b3;
  display: block;
  margin-bottom: 0.75rem;
}
.service-card[_ngcontent-%COMP%]   h3[_ngcontent-%COMP%] {
  font-size: 1.1rem;
  color: #1a2940;
  margin-bottom: 0.5rem;
}
.service-card[_ngcontent-%COMP%]   p[_ngcontent-%COMP%] {
  color: #555;
  font-size: 0.9rem;
}



.products-section[_ngcontent-%COMP%] {
  padding: 4rem 1.5rem;
  max-width: 1400px;
  margin: 0 auto;
}

.products-swiper[_ngcontent-%COMP%] {
  padding-bottom: 2.5rem;
}
.products-swiper[_ngcontent-%COMP%]   .swiper-slide[_ngcontent-%COMP%] {
  width: 260px;
}

.product-card[_ngcontent-%COMP%] {
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  background: #fff;
}
.product-card__img-wrap[_ngcontent-%COMP%] {
  height: 180px;
  overflow: hidden;
}
.product-card[_ngcontent-%COMP%]   img[_ngcontent-%COMP%] {
  width: 100%;
  height: 100%;
  -o-object-fit: cover;
     object-fit: cover;
  transition: transform 0.3s;
}
.product-card[_ngcontent-%COMP%]:hover   img[_ngcontent-%COMP%] {
  transform: scale(1.05);
}
.product-card[_ngcontent-%COMP%]   h3[_ngcontent-%COMP%], .product-card[_ngcontent-%COMP%]   p[_ngcontent-%COMP%] {
  padding: 0 1rem;
}
.product-card[_ngcontent-%COMP%]   h3[_ngcontent-%COMP%] {
  margin: 0.75rem 0 0.25rem;
  font-size: 1rem;
  color: #1a2940;
}
.product-card[_ngcontent-%COMP%]   p[_ngcontent-%COMP%] {
  font-size: 0.85rem;
  color: #555;
  margin-bottom: 1rem;
}



.why-us[_ngcontent-%COMP%] {
  background: #0074b3;
  padding: 4rem 1.5rem;
}
.why-us__grid[_ngcontent-%COMP%] {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  max-width: 1200px;
  margin: 0 auto;
}
@media (max-width: 768px) {
  .why-us__grid[_ngcontent-%COMP%] {
    grid-template-columns: 1fr;
  }
}

.why-card[_ngcontent-%COMP%] {
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  padding: 2rem;
  text-align: center;
  color: #fff;
}
.why-card__icon[_ngcontent-%COMP%] {
  font-size: 2rem;
  display: block;
  margin-bottom: 0.75rem;
}
.why-card[_ngcontent-%COMP%]   h3[_ngcontent-%COMP%] {
  margin-bottom: 0.5rem;
}
.why-card[_ngcontent-%COMP%]   p[_ngcontent-%COMP%] {
  opacity: 0.85;
  font-size: 0.9rem;
}



.trust-strip[_ngcontent-%COMP%] {
  background: #f0f7fc;
  padding: 2.5rem 1.5rem;
  text-align: center;
}
.trust-strip__heading[_ngcontent-%COMP%] {
  font-size: 1.25rem;
  font-weight: 700;
  color: #0074b3;
  margin-bottom: 1.5rem;
}
.trust-strip__logos[_ngcontent-%COMP%] {
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
  max-width: 800px;
  margin: 0 auto;
}
.trust-strip__placeholder[_ngcontent-%COMP%] {
  width: 100px;
  height: 60px;
  background: #dce9f5;
  border-radius: 8px;
}



.cta-section[_ngcontent-%COMP%] {
  background: linear-gradient(135deg, #005a8e, #1a2940);
  padding: 5rem 1.5rem;
  text-align: center;
  color: #fff;
}
.cta-section[_ngcontent-%COMP%]   h2[_ngcontent-%COMP%] {
  font-size: 2rem;
  margin-bottom: 1rem;
}
.cta-section[_ngcontent-%COMP%]   p[_ngcontent-%COMP%] {
  opacity: 0.9;
  margin-bottom: 2rem;
  font-size: 1.1rem;
}
.cta-section__buttons[_ngcontent-%COMP%] {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}`]})}export{h as HomeComponent};
