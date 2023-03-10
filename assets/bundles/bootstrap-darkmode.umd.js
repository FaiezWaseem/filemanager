(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define('bootstrap-darkmode', ['exports'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global["bootstrap-darkmode"] = {}));
})(this, (function (exports) { 'use strict';

    var ThemeConfig = /** @class */ (function () {
        function ThemeConfig() {
            this.themeChangeHandlers = [];
        }
        ThemeConfig.prototype.loadTheme = function () {
            return localStorage.getItem('theme');
        };
        ThemeConfig.prototype.saveTheme = function (theme) {
            if (theme === null) {
                localStorage.removeItem('theme');
            }
            else {
                localStorage.setItem('theme', theme);
            }
        };
        ThemeConfig.prototype.initTheme = function () {
            this.displayTheme(this.getTheme());
        };
        ThemeConfig.prototype.detectTheme = function () {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        };
        ThemeConfig.prototype.getTheme = function () {
            return this.loadTheme() || this.detectTheme();
        };
        ThemeConfig.prototype.setTheme = function (theme) {
            this.saveTheme(theme);
            this.displayTheme(theme);
        };
        ThemeConfig.prototype.displayTheme = function (theme) {
            document.body.setAttribute('data-theme', theme);
            for (var i = 0; i < this.themeChangeHandlers.length; i++) {
                this.themeChangeHandlers[i](theme);
            }
        };
        return ThemeConfig;
    }());

    function writeDarkSwitch(config) {
        document.write("\n<div class=\"custom-control custom-switch\">\n<input type=\"checkbox\" class=\"custom-control-input\" id=\"darkSwitch\">\n<label class=\"custom-control-label\" for=\"darkSwitch\">Dark Mode</label>\n</div>\n");
        var darkSwitch = document.getElementById('darkSwitch');
        darkSwitch.checked = config.getTheme() === 'dark';
        darkSwitch.onchange = function () {
            config.setTheme(darkSwitch.checked ? 'dark' : 'light');
        };
        config.themeChangeHandlers.push(function (theme) { return darkSwitch.checked = theme === 'dark'; });
        return darkSwitch;
    }

    /**
     * Generated bundle index. Do not edit.
     */

    exports.ThemeConfig = ThemeConfig;
    exports.writeDarkSwitch = writeDarkSwitch;

    Object.defineProperty(exports, '__esModule', { value: true });

}));
//# sourceMappingURL=bootstrap-darkmode.umd.js.map
