/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 84);
/******/ })
/************************************************************************/
/******/ ({

/***/ 84:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(85);


/***/ }),

/***/ 85:
/***/ (function(module, exports) {

new Vue({
  el: '#debe_cilindros',
  data: function data() {
    return {
      tbl_datatable: null,
      dt_tbl_datatable: []
    };
  },

  methods: {
    btnOnClick_btnCancelar: function btnOnClick_btnCancelar() {
      console.log('cancelar');
    }
  },
  mounted: function mounted() {
    this.tbl_datatable = $('#tbl_datatable');
    this.dt_tbl_datatable = this.tbl_datatable.DataTable({
      data: this.producciones,
      // rowCallback: function (r, d) {
      //   // console.log(this)
      //   console.log(r)
      //   console.log(d)
      //   if (+d.anulado == 1) {
      //     r.classList.add("mystyle")
      //   }
      //   // if ()
      // },
      dom: '<"table-responsive"t>p',
      pageLength: 10,
      processing: true,
      ajax: {
        url: BASE_URL + '/home/propietarios/datatable_deben',
        data: function data(d) {
          // d.buscar = _this3.filtros.query;
          // if (_this3.filtros.success_date) {
          //   d.filtro_date = _this3.filtros.filtro_date;
          //   d.desde = _this3.filtros.fecha_desde;
          //   d.hasta = _this3.filtros.fecha_hasta;
          // }
        }
      },
      serverSide: true,
      columns: [{ data: 'nombre' }, { data: 'cantidad' }, { data: 'desde_deuda' }, { data: 'ent_id' }]
      // columnDefs: [{
      //   targets: [6],
      //   className: 'text-right'
      // }]
    });

    // $('#tbl_datatable').on('click', '.btn-acciones', this.fnOnClick_btnAcciones);
  }
});

/***/ })

/******/ });