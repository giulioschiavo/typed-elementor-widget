/**
 * Initialization script for the Typed.js Elementor Widget.
 */
(function () {
  'use strict';

  function typeelwiParseConfig(wrapper) {
    var rawConfig = wrapper.getAttribute('data-typeelwi-config');

    if (!rawConfig) {
      return null;
    }

    try {
      return JSON.parse(rawConfig);
    } catch (error) {
      return null;
    }
  }

  function typeelwiSyncCursor(wrapper, output) {
    var attempts = 0;
    var interval = window.setInterval(function () {
      var cursor = wrapper.querySelector('.typed-cursor');
      attempts += 1;

      if (cursor) {
        window.clearInterval(interval);

        if (output._typeelwiResizeHandler) {
          window.removeEventListener('resize', output._typeelwiResizeHandler);
        }

        output._typeelwiResizeHandler = function () {
          cursor.style.fontSize = window.getComputedStyle(output).fontSize;
        };

        output._typeelwiResizeHandler();
        window.addEventListener('resize', output._typeelwiResizeHandler);
      }

      if (attempts > 20) {
        window.clearInterval(interval);
      }
    }, 50);
  }

  function typeelwiInitWidget(wrapper) {
    var output = wrapper.querySelector('.typeelwi-typed-output');
    var config = typeelwiParseConfig(wrapper);

    if (!output || !config || typeof window.Typed !== 'function') {
      return;
    }

    if (output._typeelwiTypedInstance) {
      output._typeelwiTypedInstance.destroy();
    }

    output._typeelwiTypedInstance = new window.Typed(output, config);
    typeelwiSyncCursor(wrapper, output);
  }

  function typeelwiInitAll(scope) {
    var root = scope && scope.querySelectorAll ? scope : document;

    root.querySelectorAll('[data-typeelwi-widget-id]').forEach(function (wrapper) {
      typeelwiInitWidget(wrapper);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      typeelwiInitAll(document);
    });
  } else {
    typeelwiInitAll(document);
  }

  function typeelwiRegisterElementorHook() {
    if (!window.elementorFrontend || !window.elementorFrontend.hooks) {
      return;
    }

    window.elementorFrontend.hooks.addAction(
      'frontend/element_ready/typeelwi_typed.default',
      function ($scope) {
        var scope = $scope && $scope[0] ? $scope[0] : document;
        typeelwiInitAll(scope);
      }
    );
  }

  if (window.elementorFrontend && window.elementorFrontend.hooks) {
    typeelwiRegisterElementorHook();
  } else {
    window.addEventListener('elementor/frontend/init', typeelwiRegisterElementorHook);
  }

  window.typeelwiReinitAll = function () {
    typeelwiInitAll(document);
  };
})();
