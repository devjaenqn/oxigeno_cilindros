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
/******/ 	return __webpack_require__(__webpack_require__.s = 78);
/******/ })
/************************************************************************/
/******/ ({

/***/ 78:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(79);


/***/ }),

/***/ 79:
/***/ (function(module, exports) {

var listar = {
  template: '#vue_produccion_listar',
  data: function data() {
    return {
      despacho_id: 0,
      sending: false,
      llegada_salida: {
        documento: '',
        fecha: '',
        hora: '',
        metodo: 0 //1 salida, 2 llegada
      },
      producciones: [],
      dt_tbl_despacho: null,
      tbl_despacho: null,
      filtros: {
        query: '',
        fecha_desde: localvalues.getVal('despacho_filter_fecha_desde', moment().format('YYYY-MM-DD')),
        fecha_hasta: localvalues.getVal('despacho_filter_fecha_hasta', moment().format('YYYY-MM-DD')),
        // fecha_desde: moment().format('YYYY-MM-DD'),
        // fecha_hasta: moment().format('YYYY-MM-DD'),
        success_date: true,
        filtro_date: 'same'
      }
    };
  },

  watch: {
    'filtros.fecha_desde': function filtrosFecha_desde(nv) {
      localvalues.setVal('despacho_filter_fecha_desde', nv);
    },
    'filtros.fecha_hasta': function filtrosFecha_hasta(nv) {
      localvalues.setVal('despacho_filter_fecha_hasta', nv);
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
    fnOnClick_modalRegistrarHora: function fnOnClick_modalRegistrarHora(e) {
      console.log(e);
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
      if (!norender) if (this.filtros.success_date) this.dt_tbl_despacho.draw();
    },
    fnOnSubmit_registrarLlegada: function fnOnSubmit_registrarLlegada() {
      var _this = this;

      var hora = moment(this.llegada_salida.fecha + ' ' + this.llegada_salida.hora);
      var metodo = '';
      if (hora.isValid() && this.llegada_salida.metodo == 1 || this.llegada_salida.metodo == 2) {
        if (this.llegada_salida.metodo == 1) metodo = 'registrar_hora_salida';else metodo = 'registrar_hora_llegada';
        this.sending = true;
        axios.put(BASE_URL + '/api/despacho/' + this.despacho_id, { metodo: metodo, hora: hora.format('YYYY-MM-DD HH:mm:ss') }).then(function (res) {
          console.log(res.data);
          if (res.data.success) {
            _this.sending = false;
            _this.dt_tbl_despacho.draw();
            $('#modRegistroLlegada').modal('hide');
            //reload datatable
            // window.location = BASE_URL + '/home/despacho'
          }
        }).catch(function (err) {
          _this.sending = false;
          console.log(err.response);
        });
      }
    },
    fnOnClick_btnAcciones: function fnOnClick_btnAcciones(e) {
      var _this2 = this;

      var dataset = e.currentTarget.dataset;
      switch (dataset.accion) {
        case 'detalles':
          break;
        case 'eliminar':
          break;
        case 'salida':
          this.sending = false;
          this.llegada_salida.documento = dataset.documento;
          this.llegada_salida.metodo = 1;
          this.llegada_salida.titulo = 'Registrar hora de salida';
          this.despacho_id = dataset.id;
          // this.llegada_salida.fecha = moment().format('YYYY-MM-DD')
          // this.llegada_salida.hora = moment().format('HH:mm')
          var fecha = moment(dataset.fecha, 'YYYY-MM-DD');
          this.llegada_salida.fecha = fecha.format('YYYY-MM-DD');
          this.llegada_salida.hora = fecha.format('HH:mm');
          $('#modRegistroLlegada').modal('show');
          $('#modRegistroLlegada').on('show.bs.modal', function (e) {
            _this2.$refs.fecha_llegada.focus();
          });
          break;
        case 'llegada':
          this.sending = false;
          this.llegada_salida.documento = dataset.documento;
          this.llegada_salida.metodo = 2;
          this.llegada_salida.titulo = 'Registrar hora de llegada';
          this.despacho_id = dataset.id;
          var fechab = moment(dataset.fecha, 'YYYY-MM-DD HH:mm');
          this.llegada_salida.fecha = fechab.format('YYYY-MM-DD');
          this.llegada_salida.hora = fechab.format('HH:mm');
          $('#modRegistroLlegada').modal('show');
          break;
        case 'confirmar':
          axios.put(BASE_URL + '/api/despacho/' + dataset.id, { metodo: 'confirmar_llegada' }).then(function (res) {
            console.log(res.data);
            if (res.data.success) {
              //reload datatable
              // window.location = BASE_URL + '/home/despacho'
              _this2.dt_tbl_despacho.draw();
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
    var _this3 = this;

    $('#modRegistroLlegada').on('hide.bs.modal', function (be) {
      console.log('cerra modal');
      _this3.llegada_salida.documento = '';
      _this3.despacho_id = 0;
      _this3.llegada_salida.hora = '';
      _this3.llegada_salida.titulo = '';
      _this3.llegada_salida.metodo = 0;
    });

    this.tbl_despacho = $('#tbl_despacho');
    this.dt_tbl_despacho = this.tbl_despacho.DataTable({
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
        url: BASE_URL + '/home/despacho/datatable?m=despacho',
        data: function data(d) {
          d.buscar = _this3.filtros.query;
          if (_this3.filtros.success_date) {
            d.filtro_date = _this3.filtros.filtro_date;
            d.desde = _this3.filtros.fecha_desde;
            d.hasta = _this3.filtros.fecha_hasta;
          }
        }
      },
      serverSide: true,
      columns: [{ data: 'fecha_emision', render: function render(d, t, r) {
          var m = moment(d);
          if (m.isValid()) return m.format('DD/MM/YYYY');else return 'no_soportado';
        } },
      // {data: 'des_id', render: (d, t, r) => {
      //   let confirma = ''
      //   let salida = ''
      //   let transporte = ''
      //   if (+r.salida == 0 && +r.llegada == 0)
      //     salida = `<span class="badge badge-primary rounded-2"><i class="fa fa-industry"></i></span>`
      //   if (+r.salida == 1 && +r.llegada == 0)
      //     transporte = `<span class="badge badge-primary rounded-2"><i class="fa fa-truck"></i></span>`
      //   if (+r.salida == 1 && +r.llegada == 1)
      //     confirma = `<span class="badge badge-primary rounded-2"><i class="fa fa-home"></i></span>`
      //     // confirma = `<span class="badge badge-success rounded-2">C</span>`

      //   if (+r.anulado == 1)
      //     return `<span class="badge badge-danger rounded-2">A</span>`
      //   else return  salida + transporte + confirma
      // }},
      // {data: 'guia.negocio.attr'},
      // {data: 'doc_serie'},
      { data: 'documento_correlativo', render: function render(d, t, r) {
          return d + (+r.anulado == 1 ? '&nbsp;<span class="badge badge-danger rounded-2">A</span>' : '');
        } }, { data: 'destino.entidad.nombre', render: function render(d, t, r) {
          return d.toUpperCase();
        } }, { data: 'destino_nombre' }, { data: 'total_cilindros' }, { data: 'total_cubicos' }, { data: 'des_id', render: function render(d, t, r) {
          var confirma = '';
          var llegada = '';
          var salida = '';
          if (+r.anulado == 0) {
            if (+r.salida == 0 && +r.llegada == 0) {
              salida = '<button class="btn btn-sm btn-default btn-accion-table  btn-acciones" data-documento="' + (r.doc_serie + '-' + r.doc_numero) + '" type="button" data-id="' + d + '" data-fecha="' + r.fecha_emision + '" data-accion="salida" title="Registrar salida"><i class="fa fa-sign-out"></i></button>';
            }
            if (+r.salida == 1 && +r.llegada == 0) {
              llegada = '<button class="btn btn-sm btn-default btn-accion-table  btn-acciones" data-documento="' + (r.doc_serie + '-' + r.doc_numero) + '" type="button" data-id="' + d + '" data-fecha="' + r.fecha_salida + '" data-accion="llegada" title="Agregar hora llegada"><i class="fa fa-sign-in"></i> </button>';
            }

            if (+r.salida == 1 && +r.llegada == 1 && +r.confirmada == 0) {
              confirma = '<button class="btn btn-sm btn-default btn-accion-table btn-acciones" type="button" data-id="' + d + '" data-accion="confirmar" title="Confirmar gu\xEDa"><i class="fa fa-check-circle"></i> </button>';
            }
          }
          return '\n                ' + salida + '\n                ' + llegada + '\n                ' + confirma + '\n                <a href="' + (BASE_URL + '/home/despacho/' + d) + '" class="btn btn-sm btn-default btn-accion-table btn-acciones btn-acciones-default"  data-id="' + d + '" data-accion="detalles" title="Detalles"><i class="fa fa-eye"></i> </a>\n                <a href="' + (BASE_URL + '/home/despacho/' + d + '/edit') + '" class="btn btn-sm btn-default btn-accion-table btn-acciones"  data-id="' + d + '" data-accion="editar" title="Editar"><i class="fa fa-pencil"></i> </a>\n                <button class="btn btn-sm btn-default btn-accion-table btn-acciones" type="button" data-id="' + d + '" data-accion="eliminar" title="Eliminar"><i class="fa fa-trash"></i> </button>\n\n              ';
        } }],
      columnDefs: [{ targets: [5], className: 'text-right' }, { targets: [4, 6], className: 'text-center' }]
    });

    $('#tbl_despacho').on('click', '.btn-acciones', this.fnOnClick_btnAcciones);
  }
};
window.onload = function () {
  var app_produccion_listar = new Vue({
    el: '#vue_despacho',
    components: {
      listar: listar
      // router
    } });
};

/***/ })

/******/ });