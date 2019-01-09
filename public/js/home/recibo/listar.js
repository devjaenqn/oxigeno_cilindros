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

var listar = {
  template: '#vue_produccion_listar',
  data: function data() {
    return {
      producciones: [],
      dt_tbl_recibo: null,
      tbl_recibo: null,
      filtros: {
        query: '',
        fecha_desde: localvalues.getVal('recibo_filter_fecha_desde', moment().format('YYYY-MM-DD')),
        fecha_hasta: localvalues.getVal('recibo_filter_fecha_hasta', moment().format('YYYY-MM-DD')),
        success_date: true,
        filtro_date: 'same'
      }
    };
  },

  watch: {
    'filtros.fecha_desde': function filtrosFecha_desde(nv) {
      localvalues.setVal('recibo_filter_fecha_desde', nv);
    },
    'filtros.fecha_hasta': function filtrosFecha_hasta(nv) {
      localvalues.setVal('recibo_filter_fecha_hasta', nv);
    }
  },
  methods: {
    getSituacion: function getSituacion(num) {
      switch (+num) {
        case 0:
          return 'extraviado';
        case 1:
          return 'fabrica';
        case 2:
          return 'exterior';
        case 3:
          return 'cliente';
      }
      return 'no_definido';
    },
    getCargado: function getCargado(num) {
      switch (+num) {
        case 0:
          return 'V';
        case 1:
          return 'R';
        case 2:
          return 'C';
      }
      return 'X';
    },
    getDefectuoso: function getDefectuoso(num) {
      switch (+num) {
        case 0:
          return 'D';
        case 1:
          return 'N';
      }
      return 'X';
    },
    onSubmit_frmAplicarFiltro: function onSubmit_frmAplicarFiltro() {
      var norender = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

      var desde = moment(this.filtros.fecha_desde);
      var hasta = moment(this.filtros.fecha_hasta);
      this.filtros.success_date = true;
      if (desde.isValid() && hasta.isValid() && desde.unix() <= hasta.unix()) {
        if (desde.unix() < hasta.unix()) {
          this.filtros.filtro_date = 'interval';
        } else if (desde.unix() == hasta.unix()) {
          this.filtros.filtro_date = 'same';
        } else {
          if (!norender) toastr.warning('Fechas no válidas para la búsqueda x', 'Revisar');
          this.filtros.success_date = false;
        }
      } else {
        if (!norender) toastr.warning('Fechas no válidas para la búsqueda', 'Revisar');
        this.filtros.success_date = false;
      }
      if (!norender) if (this.filtros.success_date) this.dt_tbl_recibo.draw();
    },
    fnOnClick_btnAcciones: function fnOnClick_btnAcciones(e) {
      var dataset = e.currentTarget.dataset;
      switch (dataset.accion) {
        case 'detalles':
          break;
        case 'eliminar':
          break;
        case 'confirmar':
          axios.put(BASE_URL + '/api/despacho/' + dataset.id, { metodo: 'confirmar_llegada' }).then(function (res) {
            console.log(res.data);
            if (res.data.success) {
              //reload datatable
              window.location = BASE_URL + '/home/despacho';
            }
          }).catch(function (err) {
            console.log(err.response);
          });
          break;
      }
    }
  },
  created: function created() {
    this.onSubmit_frmAplicarFiltro(true);
    // axios.get(BASE_URL + '/api/cilindro').then(res => {
    //   console.log(res)
    //   this.producciones = res.data
    // })
  },
  mounted: function mounted() {
    var _this = this;

    this.tbl_recibo = $('#tbl_recibo');
    this.dt_tbl_recibo = this.tbl_recibo.DataTable({
      data: this.producciones,
      pageLength: 10,
      processing: true,
      ajax: {
        url: BASE_URL + '/home/despacho/datatable?m=recibo',
        data: function data(d) {
          d.buscar = _this.filtros.query;
          if (_this.filtros.success_date) {
            d.filtro_date = _this.filtros.filtro_date;
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
      columns: [{ data: 'fecha_emision' },
      // {data: 'guia.negocio.attr'},
      // {data: 'doc_serie'},
      { data: 'documento_correlativo', render: function render(d, t, r) {
          return d + (+r.anulado == 1 ? '&nbsp;<span class="badge badge-danger rounded-2">A</span>' : '');
        } }, { data: 'destino.entidad.nombre', render: function render(d, t, r) {
          return d.toUpperCase();
        } }, { data: 'destino_nombre' }, { data: 'total_cilindros' }, { data: 'total_cubicos' }, { data: 'des_id', render: function render(d, t, r) {
          var confirma = '';
          // if (+r.confirmada == 0) {
          //   if (+r.anulado == 0)
          //     confirma = `<button class="btn btn-sm btn-default btn-accion-table btn-acciones" type="button" data-id="${d}" data-accion="confirmar" title="Confirmar llegada"><i class="fa fa-check-circle"></i> </button>`
          // }
          return '\n                ' + confirma + '\n                <a href="' + (BASE_URL + '/home/recibo/' + d) + '" class="btn btn-sm btn-default btn-accion-table btn-acciones btn-acciones-default"  data-id="' + d + '" data-accion="detalles" title="Detalles"><i class="fa fa-eye"></i> </a>\n                <a href="' + (BASE_URL + '/home/recibo/' + d + '/edit') + '" class="btn btn-sm btn-default btn-accion-table btn-acciones"  data-id="' + d + '" data-accion="editar" title="Editar"><i class="fa fa-pencil"></i> </a>\n                <button class="btn btn-sm btn-default btn-accion-table btn-acciones" type="button" data-id="' + d + '" data-accion="eliminar" title="Eliminar"><i class="fa fa-trash"></i> </button>\n\n              ';
        } }],
      columnDefs: [{ targets: [5], className: 'text-right' }, { targets: [4, 6], className: 'text-center' }]
    });

    this.tbl_recibo.on('click', '.btn-acciones', this.fnOnClick_btnAcciones);
  }
};
window.onload = function () {
  var app_produccion_listar = new Vue({
    el: '#vue_recibo',
    components: {
      listar: listar
      // router
    } });
};

/***/ })

/******/ });