/*! layout-utils.js v1.0 */
(function (global) {
    'use strict';
  
    function px(n) { return (n || 0) + 'px'; }
  
    function getEl(idOrEl) {
      if (!idOrEl) return null;
      if (typeof idOrEl === 'string') return document.getElementById(idOrEl);
      return idOrEl.nodeType === 1 ? idOrEl : null;
    }
  
    function getHeaderHeight(header) {
      const el = getEl(header);
      if (!el) return 0;
      // รวมขอบ/เงา/เส้นขีด; ใช้ offsetHeight เพื่อความชัวร์
      return el.offsetHeight || el.clientHeight || 0;
    }
  
    function applySpacing({ header, target, extra = 8, mode = 'margin' }) {
      const h = getHeaderHeight(header);
      const el = getEl(target);
      if (!el) return;
      if (mode === 'padding') {
        el.style.paddingTop = px(h + extra);
      } else {
        el.style.marginTop = px(h + extra);
      }
    }
  
    function adjustContentSpacing(header = 'header', content = 'content', extra = 8) {
      applySpacing({ header, target: content, extra, mode: 'margin' });
    }
  
    function adjustBodySpacing(header = 'header', extra = 8) {
      applySpacing({ header, target: document.body, extra, mode: 'padding' });
    }
  
    // throttle แบบเบา ๆ
    function throttle(fn, wait) {
      let t = 0, scheduled = false, lastArgs;
      return function (...args) {
        lastArgs = args;
        if (scheduled) return;
        const now = Date.now();
        const remain = Math.max(0, wait - (now - t));
        scheduled = true;
        setTimeout(() => {
          t = Date.now();
          scheduled = false;
          fn.apply(null, lastArgs);
        }, remain);
      };
    }
  
    /**
     * Auto apply spacing และดูการเปลี่ยนแปลงความสูง header อัตโนมัติ
     * @param {Object} opts
     *  - header: id หรือ element ของ header (default: 'header')
     *  - target: id หรือ element ของ target (default: 'content' สำหรับ margin) หรือ document.body ถ้าใช้ mode='padding'
     *  - extra: จำนวน px เผื่อเว้นเพิ่ม (default: 8)
     *  - mode: 'margin' | 'padding' (default: 'margin')
     */
    function autoSpacing(opts = {}) {
      const {
        header = 'header',
        target = (opts.mode === 'padding' ? document.body : 'content'),
        extra = 8,
        mode = 'margin'
      } = opts;
  
      const run = throttle(() => applySpacing({ header, target, extra, mode }), 50);
  
      // initial
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run, { once: true });
      } else {
        run();
      }
      window.addEventListener('load', run);
      window.addEventListener('resize', run);
  
      // ติดตามความสูง header แบบ realtime (เช่น เมนูยุบ/ขยาย)
      const headerEl = getEl(header);
      if (headerEl && 'ResizeObserver' in window) {
        const ro = new ResizeObserver(run);
        ro.observe(headerEl);
      }
    }
  
    // UMD-lite exports
    const api = {
      adjustContentSpacing,
      adjustBodySpacing,
      autoSpacing
    };
  
    // attach global
    global.LayoutUtils = api;
  
  })(typeof window !== 'undefined' ? window : this);
  