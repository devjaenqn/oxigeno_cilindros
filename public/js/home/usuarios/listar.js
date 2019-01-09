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
/******/ 	return __webpack_require__(__webpack_require__.s = 90);
/******/ })
/************************************************************************/
/******/ ({

/***/ 90:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(91);


/***/ }),

/***/ 91:
/***/ (function(module, exports) {

var listar = {
  template: '#listar',
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
        fecha_desde: moment().format('YYYY-MM-DD'),
        fecha_hasta: moment().format('YYYY-MM-DD'),
        success_date: true,
        filtro_date: 'same'
      }
    };
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

      if (this.filtros.success_date) this.dt_tbl_despacho.draw();
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
    console.log(this);
    console.log('componente cargado');
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
        url: BASE_URL + '/home/usuarios/datatables',
        data: function data(d) {
          d.buscar = _this3.filtros.query;
          // if (this.filtros.success_date) {
          //   d.filtro_date = this.filtros.filtro_date
          //   d.desde = this.filtros.fecha_desde
          //   d.hasta = this.filtros.fecha_hasta
          // }
        }
      },
      serverSide: true,
      columns: [
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
      { data: 'nombres' }, { data: 'apellidos' }, { data: 'telefono' }, { data: 'cuenta_usuario' }, { data: 'slug' }, { data: 'du_id' }],
      columnDefs: [
        // {
        //   targets: [6],
        //   className: 'text-right'
        // }
      ]
    });

    $('#tbl_despacho').on('click', '.btn-acciones', this.fnOnClick_btnAcciones);
  }
};
var app_produccion_listar = new Vue({
  el: '#master_vue',
  components: {
    listar: listar
    // router
  } });

/***/ })

/******/ });