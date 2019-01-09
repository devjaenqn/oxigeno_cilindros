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
/******/ 	return __webpack_require__(__webpack_require__.s = 76);
/******/ })
/************************************************************************/
/******/ ({

/***/ 76:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(77);


/***/ }),

/***/ 77:
/***/ (function(module, exports) {

var listar = {
  template: '#vue_produccion_listar',
  data: function data() {
    return {
      producciones: [],
      tbl_produccion: null,
      dt_tbl_produccion: null,
      filtros: {
        query: '',
        // fecha_desde: moment().format('YYYY-MM-DD'),
        fecha_desde: localvalues.getVal('produccion_filter_fecha_desde', moment().format('YYYY-MM-DD')),
        // fecha_hasta: moment().format('YYYY-MM-DD'),
        fecha_hasta: localvalues.getVal('produccion_filter_fecha_hasta', moment().format('YYYY-MM-DD')),
        success_date: true,
        filtro_date: 'same'
      }
    };
  },

  watch: {
    'filtros.fecha_desde': function filtrosFecha_desde(nv) {
      localvalues.setVal('produccion_filter_fecha_desde', nv);
    },
    'filtros.fecha_hasta': function filtrosFecha_hasta(nv) {
      localvalues.setVal('produccion_filter_fecha_hasta', nv);
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
      if (!norender) {
        if (this.filtros.success_date) this.dt_tbl_produccion.draw();
      }
    },
    fnOnClick_btnAcciones: function fnOnClick_btnAcciones(e) {
      var dataset = e.currentTarget.dataset;
      switch (dataset.accion) {
        case 'finalizar':
          axios.put(BASE_URL + '/api/produccion/' + dataset.id, { modo: 'finalizar' }).then(function (res) {
            console.log(res.data);
            if (res.data.success) {
              toastr.success('Carga de cilindros en ' + res.data.data.sistema_lote + ', lote ' + (res.data.data.numero_lote + '-' + res.data.data.serie_lote) + ' finalizada', 'Carga finalizada');
            }
          }).catch(function (err) {
            console.log(err.response);
          });
          break;
        case 'detalles':
          break;
        case 'eliminar':
          break;
      }
    }
  },
  created: function created() {
    this.onSubmit_frmAplicarFiltro(true);
    console.log(this);
    // axios.get(BASE_URL + '/api/cilindro').then(res => {
    //   console.log(res)
    //   this.producciones = res.data
    // })
  },
  mounted: function mounted() {
    var _this = this;

    // this.producciones = res.data
    this.tbl_produccion = $('#tbl_produccion');
    this.dt_tbl_produccion = this.tbl_produccion.DataTable({
      data: this.producciones,
      dom: '<"table-responsive"t>p',
      pageLength: 10,
      processing: true,
      ajax: {
        url: BASE_URL + '/home/produccion/datatable',
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
      columns: [{ data: 'fecha' },
      // {data: 'serie_lote', render: (d, t, r) => {
      { data: 'sistema_lote', render: function render(d, t, r) {
          return d.toUpperCase();
        } },
      // {data: 'numero_lote'},
      { data: 'lote_format' }, { data: 'entrada', render: function render(d, t, r) {
          var date = moment(d);
          return '<span title="' + date.format('HH:mm') + '">' + date.format('hh:mm A') + '</span>';
        } }, { data: 'salida', render: function render(d, t, r) {
          var date = moment(d);
          return '<span title="' + date.format('HH:mm') + '">' + date.format('hh:mm A') + '</span>';
        } }, { data: 'total_cilindros' }, { data: 'total_presion' }, { data: 'operador', render: function render(d, t, r) {
          return (d.nombre + ' ' + d.apellidos).toUpperCase();
        } }, { data: 'pro_id', render: function render(d, t, r) {
          var btn_finaliza = '';
          if (+r.finalizado == 0) btn_finaliza = '\n                    <button class="btn btn-sm btn-default btn-accion-table btn-acciones" type="button" data-id="' + d + '" data-accion="finalizar" title="Finalizar carga"><i class="fa fa-check"></i> </button>\n                    ';

          return '\n                  ' + btn_finaliza + '\n                  <a href="' + (BASE_URL + '/home/produccion/' + d) + '" class="btn btn-sm btn-default btn-accion-table btn-acciones btn-acciones-default"  data-id="' + d + '" data-accion="detalles" title="Detalles"><i class="fa fa-eye"></i> </a>\n                  <a href="' + (BASE_URL + '/home/produccion/' + d + '/edit') + '" class="btn btn-sm btn-default btn-accion-table btn-acciones"  data-id="' + d + '" data-accion="editar" title="Editar"><i class="fa fa-pencil"></i> </a>\n                  <button class="btn btn-sm btn-default btn-accion-table btn-acciones" type="button" data-id="' + d + '" data-accion="eliminar" title="Eliminar"><i class="fa fa-trash"></i> </button>\n\n                ';
        } }],
      columnDefs: [{
        targets: [8],
        className: 'text-center'
      }]
    });

    this.tbl_produccion.on('click', '.btn-acciones', this.fnOnClick_btnAcciones);
  }
};

window.onload = function () {
  var app_produccion_listar = new Vue({
    el: '#vue_produccion',
    components: {
      listar: listar
      // router
    } });
};

/***/ })

/******/ });