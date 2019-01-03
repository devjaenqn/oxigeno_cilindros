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
/******/ 	return __webpack_require__(__webpack_require__.s = 80);
/******/ })
/************************************************************************/
/******/ ({

/***/ 80:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(81);


/***/ }),

/***/ 81:
/***/ (function(module, exports) {

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

//VALIDAR TIEMPO 00-24
//var g = RegExp('([01]+[0-9]|2[0-3])')
//var g = RegExp('([01]+[0-9]|2[0-3]):[0-5][0-9]')
var registro = {
  template: '#vue_recibo_registro',
  data: function data() {
    return _extends({}, data_vue, {
      // comprobante_success: false,
      // serie_comprobante: '',
      // numero_comprobante: '',
      fecha_emision: moment().format('YYYY-MM-DD'),
      anular: false,
      // motivo: 'VENTA',
      turno: '7AM - 7PM',
      entrada: '00:00',
      salida: '00:00',
      // referencia: '',
      observacion: '',
      // sistema: 0,
      // total_cilindros: 0,
      // total_libras: 0,
      cliente: {
        id: 0,
        nombre: '',
        direccion: '',
        tipo_doc: '',
        numero_doc: '',
        destino: 0, // 0 = agregar nuevo destino
        destino_nombre: '',
        destinos: []

      },
      cilindros: [],
      cilindro: {
        id: 0,
        serie: '',
        codigo: '',
        capacidad: 0,
        propietario: '',
        propietario_id: 0,
        // motivo: '',
        delete: true,
        cantidad: 0,
        tapa: 0,
        registrado: 0,
        observacion: ''
      }
    });
  },


  methods: {
    resetForm: function resetForm() {
      this.anular = false;
    },
    resetCilindro: function resetCilindro() {

      this.cilindro.id = 0;
      this.cilindro.serie = '';
      this.cilindro.codigo = '';
      this.cilindro.capacidad = 0;
      this.cilindro.propietario = '';
      this.cilindro.propietario_id = 0;
      this.cilindro.cantidad = 0;
      this.cilindro.tapa = 0;
      this.cilindro.delete = true;
      this.cilindro.registrado = 0;
      this.cilindro.observacion = '';
    },
    resetCliente: function resetCliente() {
      this.cliente.id = 0;
      this.cliente.nombre = '';
      this.cliente.direccion = '';
      this.cliente.tipo_doc = '';
      this.cliente.numero_doc = '';
      this.cliente.destino = 0;
      this.cliente.destino_nombre = '';
      this.cliente.destinos = [];
    },
    findComprobante: function findComprobante(comprobante_id) {
      // this.data_negocios.forEach(v => {

      // })
      var guia = null;
      var negocio = null;
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = this.data_negocios[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var neg = _step.value;


          guia = neg.recibos.find(function (v) {
            return v.cne_id == comprobante_id;
          });
          if (typeof guia != 'undefined') {
            negocio = neg;
            break;
          } else guia = null;
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      return { guia: guia, negocio: negocio };
      // console.log(sis)
      // let lote = this.data_lotes.find(v => {
      //   return v.sistema_attr == sis.attr
      // })
      // console.log(lote)
    },
    findLocacion: function findLocacion() {},
    cilindroExiste: function cilindroExiste(cilindro_id) {
      var target = this.cilindros.find(function (v) {
        return v.id == cilindro_id;
      });
      return typeof target != 'undefined';
    },
    frmOnClick_frmAnular: function frmOnClick_frmAnular() {
      console.log('anular');
      this.anular = true;
      this.frmOnSubmit_frmRegistro();
    },
    frmOnSubmit_frmRegistro: function frmOnSubmit_frmRegistro() {
      var _this2 = this;

      msg.pregunta('Recibo', '¿Dese continuar?', function (quest) {
        if (quest) {
          var now = moment();
          if (_this2.comprobante_success) {
            // if (entrada.isValid() && salida.isValid()){
            var success_reg = true;

            if (_this2.cliente.id == 0) {
              success_reg = false;
              toastr.warning('Seleccione un cliente', 'Revisar');
            }

            if (_this2.comprobante == 0) {
              success_reg = false;
              toastr.error('Guía no encontrada', 'Error');
            }
            if (!_this2.anular) {
              if (_this2.cilindros.length <= 0) {
                success_reg = false;
                toastr.warning('Registre al menos un cilindro', 'Revisar');
              }
            }

            if (_this2.cliente.destino != 0) {
              var locacion = _this2.cliente.destinos.find(function (v) {
                return v.locacion.toUpperCase().trim() == _this2.cliente.destino_nombre.toUpperCase().trim();
              });

              if (typeof locacion == 'undefined') _this2.cliente.id = 0;
            }

            if (_this2.cliente.destino_nombre.trim() == '') {
              success_reg = false;
              toastr.warning('Ingrese destino', 'Revisar');
            }

            if (success_reg) {
              var sendData = {
                negocio: _this2.negocio,
                anular: _this2.anular ? '1' : '0',
                comprobante: _this2.comprobante,
                serie: _this2.serie_comprobante,
                // referencia: this.referencia,
                numero: _this2.numero_comprobante,
                fecha: _this2.fecha_emision,
                // motivo: this.motivo,
                observacion: _this2.observacion,
                cliente: _this2.cliente.id,
                destino: _this2.cliente.destino,
                destino_nombre: _this2.cliente.destino_nombre.toUpperCase(),
                total_cilindros: _this2.total_cilindros,
                total_presion: _this2.total_libras,
                total_cubicos: _this2.total_cubicos,
                cilindros: _this2.cilindros,
                metodo: _this2.is_edit ? 'modificar_recibo' : ''
              };
              if (_this2.is_edit) {
                return axios.put(BASE_URL + '/api/recibo/' + _this2.data_despacho.des_id, sendData);
              } else {
                return axios.post(BASE_URL + '/api/recibo', sendData);
              }
            }

            // } else {
            //   //fechas invalidas
            //   toastr.warning('Fechas no válidas', 'Revisar')
            // }
          } else {
            toastr.error('Lote no encontrado', 'Error');
          }
        }
      }).then(function (res) {
        if (res.data) {
          if (res.data.success) {
            var mensaje = 'Elemento registrado con éxito!';
            if (_this2.is_edit) {
              mensaje = 'Elemento actualizado con éxito';
            }
            msg.success('Recibo', mensaje, 5000).then(function (event) {
              location.href = base_url('home/recibo');
            });
          } else {
            if (_this2.anular) _this2.anular = false;
            if (res.data.show_message) {
              toastr.warning(res.data.msg, 'Revisar!');
            }
          }
        } else if (res.cancel) {
          console.log('cancel proce');
          if (_this2.anular) _this2.anular = false;
        }
      });
    },
    frmOnSubmit_frmAgregaCilindro: function frmOnSubmit_frmAgregaCilindro() {
      console.log('registrar cilindro');
      if (!this.cilindroExiste(this.cilindro.id)) {
        if (this.cilindro.id != 0) {
          this.cilindros.push({
            id: this.cilindro.id,
            serie: this.cilindro.serie,
            codigo: this.cilindro.codigo,
            capacidad: this.cilindro.capacidad,
            propietario: this.cilindro.propietario,
            propietario_id: this.cilindro.propietario_id,
            cantidad: this.cilindro.cantidad,
            tapa: this.cilindro.tapa,
            delete: this.cilindro.delete,
            registrado: this.cilindro.registrado,
            // motivo: this.cilindro.motivo,
            observacion: this.cilindro.observacion
          });
          this.$refs.cilindro_th.focus();
        } else {
          toastr.warning('Cilindro no seleccionado', 'Revisar');
        }
      } else {
        toastr.warning('Cilindro ya fue agregado', 'Error');
      }
      this.resetCilindro();
    },
    fnTargetDestino: function fnTargetDestino(e, d) {
      console.log(d);
      this.cliente.destino = d.elo_id;
      this.cliente.destino_nombre = d.locacion;
    },
    fnTargetCilindro: function fnTargetCilindro(e, d) {
      console.log(d);
      this.cilindro.id = d.cil_id;
      this.cilindro.serie = d.serie;
      this.cilindro.codigo = d.codigo;
      this.cilindro.capacidad = d.capacidad;
      this.cilindro.propietario = d.propietario.nombre.toUpperCase();
      this.cilindro.propietario_id = d.propietario_id;
      this.cilindro.cantidad = d.presion;
      this.cilindro.tapa = +d.tapa;
    },
    fnTargetCliente: function fnTargetCliente(e, d) {
      this.resetCliente();
      console.log(d);
      this.cliente.id = d.ent_id;
      this.cliente.nombre = d.nombre;
      this.cliente.direccion = d.direccion;
      this.cliente.tipo_doc = d.documento.corto;
      this.cliente.numero_doc = d.numero;
      this.cliente.destinos = d.locaciones;
      var predeterminado = this.cliente.destinos.find(function (v) {
        return +v.predeterminado == 1;
      });
      if (typeof predeterminado != 'undefined') {
        this.cliente.destino = predeterminado.elo_id;
        $('#destino').typeahead('val', predeterminado.locacion);
        this.cliente.destino_nombre = predeterminado.locacion;
      }
      // this.cilindro.id = d.cil_id
      // this.cilindro.serie = d.serie
      // this.cilindro.codigo = d.codigo
      // this.cilindro.capacidad = d.capacidad
      // this.cilindro.propietario = d.propietario.nombre
      // this.cilindro.propietario_id = d.propietario.id
      // this.cilindro.cantidad = d.presion
    }
  },
  watch: {
    comprobante: function comprobante(nv, ov) {
      // console.log(nv)
      var comprobante = this.findComprobante(nv);
      console.log(comprobante);
      if (comprobante) {
        this.comprobante = comprobante.guia.cne_id;
        this.serie_comprobante = comprobante.guia.serie;
        this.numero_comprobante = comprobante.guia.actual;
        this.negocio = comprobante.negocio.neg_id;
        this.comprobante_success = true;
      } else {
        this.comprobante_success = false;
        this.comprobante = 0;
        this.negocio = 0;
        this.serie_comprobante = '';
        this.numero_comprobante = '';
        toastr.error("El negocio no posee guía de remisión", "Sistema - Error");
      }
      // if (nv != 0) {

      // }
    }
  },
  computed: {
    total_cilindros: function total_cilindros() {
      return this.cilindros.length;
    },
    total_libras: function total_libras() {
      var sum = 0;
      this.cilindros.forEach(function (v) {

        sum += +v.cantidad;
      });
      return sum;
    },
    total_cubicos: function total_cubicos() {
      var sum = 0;
      this.cilindros.forEach(function (v) {

        sum += +v.capacidad;
      });
      return sum;
    }
  },
  created: function created() {
    console.log(this);
    if (this.is_edit) {
      this.comprobante = this.data_despacho.documento_id;
      this.serie_comprobante = this.data_despacho.doc_serie;
      this.numero_comprobante = this.data_despacho.doc_numero;
      this.fecha_emision = this.data_despacho.fecha_emision;
      // this.motivo = this.data_despacho.motivo
      // this.referencia = this.data_despacho.doc_referencia
      this.observacion = this.data_despacho.observacion;

      this.cliente.id = this.data_despacho.destino.entidad.ent_id;
      this.cliente.nombre = this.data_despacho.destino.entidad.nombre;
      this.cliente.direccion = this.data_despacho.destino.entidad.direccion;
      this.cliente.tipo_doc = this.data_despacho.destino.entidad.documento.corto;
      this.cliente.numero_doc = this.data_despacho.destino.entidad.numero;
      this.cliente.destino = this.data_despacho.destino.elo_id;
      this.cliente.destino_nombre = this.data_despacho.destino.locacion;
      this.cliente.destinos = this.data_despacho.destino.entidad.locaciones;

      this.cilindros = this.data_despacho.detalles.map(function (v) {

        return {
          id: v.cilindro_id,
          serie: v.cilindro_serie,
          codigo: v.cilindro_codigo,
          capacidad: v.des_capacidad,
          propietario: v.propietario_nombre,
          propietario_id: v.propietario.ent_id,
          cantidad: v.des_presion,
          registrado: 1,
          tapa: +v.cilindro_tapa,
          delete: false,
          observacion: v.observacion
        };
      });
    }
    // this.negocio = this.data_negocios[0].sis_id
  },
  mounted: function mounted() {
    var _this3 = this;

    var _this = this;
    autosize(document.getElementById('observacion'));
    autosize(document.getElementById('observacion_cilindro'));
    // $("#entrada").mask("99:99");
    // $("#salida").mask("99:99");


    $('#cliente').typeahead({
      highlight: true,
      hint: false,
      minLength: 1
    }, {
      async: true,
      name: 'buscar-cliente',
      display: function display(d) {
        return d.nombre;
      },
      source: function source(q, cb, asy) {
        // let result = []
        if (q.trim() != '') {
          axios.get(BASE_URL + '/api/propietarios?qq=' + q).then(function (res) {
            // console.log(res.data)
            // return res.data
            asy(res.data);
            // return res.data
          });

          // let regex = new RegExp(q, 'i');
          // cb(_this.listaBancos.filter(v => {
          //   return regex.test(v.banco_name)
          // }))
        }
      }
    }).bind('typeahead:select', this.fnTargetCliente).bind('typeahead:autocomplete', this.fnTargetCliente);

    $('#destino').typeahead({
      highlight: true,
      hint: false,
      minLength: 1
    }, {
      async: true,
      name: 'buscar-destino',
      display: function display(d) {
        d.locacion = d.locacion.toUpperCase();
        return d.locacion;
      },
      source: function source(q, cb, asy) {
        // let result = []
        if (q.trim() != '') {
          // axios.get(BASE_URL + '/api/propietarios?qq=' + q).then(res => {
          //   // console.log(res.data)
          //   // return res.data
          //   asy(res.data)
          //   // return res.data
          // })

          var regex = new RegExp(q, 'i');
          cb(_this3.cliente.destinos.filter(function (v) {
            return regex.test(v.locacion);
          }));
        }
      }
    }).bind('typeahead:select', this.fnTargetDestino).bind('typeahead:autocomplete', this.fnTargetDestino);

    $('#cilindro_th').typeahead({
      highlight: true,
      hint: false,
      minLength: 1
    }, {
      async: true,
      name: 'buscar-serie-cilindro-recibo',
      display: function display(d) {
        return d.serie;
      },
      source: function source(q, cb, asy) {
        // let result = []
        if (q.trim() != '') {
          var no_buscar = _this.cilindros.map(function (v) {
            return v.id;
          });
          axios.get(BASE_URL + '/api/cilindro', { params: {
              m: this.is_edit ? 'editar' : 'recibo',
              q: q,
              cilindros: no_buscar
            } }).then(function (res) {
            // axios.get(BASE_URL + '/api/cilindro?m=all&q=' + q).then(res => {
            // console.log(res.data)
            // return res.data
            asy(res.data);
            // return res.data
          }).catch(function (err) {
            console.log(err.response);
          });

          // let regex = new RegExp(q, 'i');
          // cb(_this.listaBancos.filter(v => {
          //   return regex.test(v.banco_name)
          // }))
        }
      }
    }).bind('typeahead:select', this.fnTargetCilindro).bind('typeahead:autocomplete', this.fnTargetCilindro);
  }
};

var app_produccion = new Vue({
  el: '#vue_recibo',
  components: {
    registro: registro
    // router
  } });

/***/ })

/******/ });