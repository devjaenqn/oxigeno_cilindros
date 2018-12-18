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
/******/ 	return __webpack_require__(__webpack_require__.s = 69);
/******/ })
/************************************************************************/
/******/ ({

/***/ 32:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
  template: '#vue_cilindro_seguimiento',
  dt_tbl_seguimiento_cilindro: null,
  tbl_seguimiento_cilindro: null,
  data: function data() {
    return {
      print_url: CURRENT_URL,
      filtros: {
        cilindro_id: getCilindro(),
        query: '',
        success_date: true,
        fecha_desde: moment([2018, 1, 1]).format('YYYY-MM-DD'),
        fecha_hasta: moment().format('YYYY-MM-DD'),
        filtro_date: 'interval'
      }
    };
  },

  watch: {
    'filtros.fecha_desde': function filtrosFecha_desde(nv, ov) {
      console.log('xxxx');
    }
  },
  methods: {
    onSubmit_frmAplicarFiltro: function onSubmit_frmAplicarFiltro() {
      var desde = moment(this.filtros.fecha_desde);
      var hasta = moment(this.filtros.fecha_hasta);
      this.filtros.success_date = true;
      if (desde.isValid() && hasta.isValid() && desde.unix() <= hasta.unix()) {
        if (desde.unix() < hasta.unix()) {
          this.filtros.filtro_date = 'interval';
        } else if (desde.unix() == hasta.unix()) {
          this.filtros.filtro_date = 'same';
        } else {
          toastr.warning('Fechas no válidas para la búsqueda x', 'Revisar');
          this.filtros.success_date = false;
        }
      } else {
        toastr.warning('Fechas no válidas para la búsqueda', 'Revisar');
        this.filtros.success_date = false;
      }

      if (this.filtros.success_date) this.dt_tbl_seguimiento_cilindro.draw();
    }
  },
  mounted: function mounted() {
    var _this = this;

    console.log(this);
    this.tbl_seguimiento_cilindro = $('#tbl_seguimiento_cilindro');
    // var temp_url = new URL(CURRENT_URL);

    // if (!temp_url.searchParams.has('e'))
    // 	temp_url.searchParams.append('e', 'pdf')
    // if (!temp_url.searchParams.has('d'))
    // 	temp_url.searchParams.append('d', this.filtros.fecha_desde)
    // if (!temp_url.searchParams.has('h'))
    // 	temp_url.searchParams.append('h', this.filtros.fecha_hasta)
    // if (!temp_url.searchParams.has('m'))
    // 	temp_url.searchParams.append('m', this.filtros.filtro_date)

    // this.print_url = temp_url.toString()

    // $('#guia_recibo').typeahead({
    //     highlight : true,
    //     hint: false,
    //     minLength: 1,
    //   },
    //   {
    //     async :true,
    //     name: 'buscar-guia-recibo',
    //     display: function(d){
    //       return d.nombre
    //     },
    //     source: function(q, cb, asy) {
    //       // let result = []
    //       if (q.trim() != '') {
    //         axios.get(BASE_URL + '/api/propietarios?qq=' + q).then(res => {
    //           // console.log(res.data)
    //           // return res.data
    //           asy(res.data)
    //           // return res.data
    //         })

    //         // let regex = new RegExp(q, 'i');
    //         // cb(_this.listaBancos.filter(v => {
    //         //   return regex.test(v.banco_name)
    //         // }))
    //       }

    //     }
    //   })
    // .bind('typeahead:select', this.fnTargetCliente)
    // .bind('typeahead:autocomplete', this.fnTargetCliente)
    this.dt_tbl_seguimiento_cilindro = this.tbl_seguimiento_cilindro.DataTable({
      data: [],
      pageLength: 10,
      processing: true,
      ajax: {
        url: BASE_URL + '/home/cilindro/seguimiento',
        data: function data(d) {
          d.buscar = _this.filtros.query;
          if (_this.filtros.success_date) {
            d.cilindro_id = _this.filtros.cilindro_id;
            d.filtro_date = _this.filtros.filtro_date;
            d.buscar = _this.filtros.query;
            d.desde = _this.filtros.fecha_desde;
            d.hasta = _this.filtros.fecha_hasta;
          }
        }
      },
      serverSide: true,
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
      // order: [[0, "desc"]],
      // bSort: false,
      columns: [{ data: 'salida' }, { data: 'guia_correlativo' }, { data: 'entrada' }, { data: 'recibo_correlativo' }],
      columnDefs: [
        // {targets: [7], className: 'text-right'}
      ]
    }).on('draw', function () {
      var g = _this.dt_tbl_seguimiento_cilindro.ajax.params();
      delete g.length;
      delete g.start;
      _this.print_url = BASE_URL + '/home/cilindro/seguimiento?' + $.param(g) + '&export=pdf';
    });
  }
});

/***/ }),

/***/ 69:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(32);


/***/ })

/******/ });