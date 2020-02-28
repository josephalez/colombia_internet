<template>
<div class="modal fade" id="modalCloneOffer" aria-modal="true" style="padding-right: 15px; display: block;">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark-blue text-white">
        <h4 class="modal-title">Clonar Oferta</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-row w-100 justify-content-around flex-wrap" v-if="!offer.fields_values.length&&fields.length">
          <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12" v-for="(field,index) in fields" >
            <label>{{field.name+(field.unit?" ("+field.unit+")":"")}}</label>
            <input v-model="fields_values[index]" class="form-control">
          </div>
        </div>
        <div class="d-flex flex-row w-100 justify-content-around flex-wrap" v-else>
          <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12" v-for="(field,index) in offer.fields_values" >
            <label>{{field.field_name+(field.unit?" ("+field.unit+")":"")}}</label>
            <input v-model="offer.fields_values[index].value" class="form-control">
          </div>
        </div>
        <div class="d-flex flex-row w-100 justify-content-around flex-wrap">
          <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <label>Descripcion</label>
            <textarea class="form-control" rows="3" placeholder="Descripcion..." v-model="offer.benefits" style="resize: none;"></textarea>
          </div>
        </div>

        <div class="d-flex flex-row w-100 justify-content-around flex-wrap">
          <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
            <label>Tarifa</label>
            <input v-model="offer.tariff" class="form-control">
          </div>
          <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
            <label>Tipo</label>
            <select class="custom-select" v-model="offer.type">
              <option :value="null">Todos</option>
              <option value="private">Hogar</option>
              <option value="company">Empresa</option>
            </select>
          </div>
          <div class="form-group col-xl-4 col-lg-4 col-md-6 col-12">
            <label>Puntuacion (Opcional)</label>
            <select class="custom-select" v-model="offer.points">
              <option value="0" selected>0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-outline-info" @click="cloneOffer">Clonar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>

</div>
</template>

<script>
export default {
  props:["offer","services"],

  data(){
    return{
      active2:false,
      fields_values:[],
      fields:[],
    }
  },

  mounted(){
    if(!this.offer.fields_values) this.getFields()
  },

  methods:{

    getFields(){
      console.log("ser-vice",this.offer.service)
      axios.get(baseUrl+"/api/service/"+this.offer.service+"/fields")
      .then(res=>{
        console.log("campos  ", res)
        this.fields=res.data;
        this.offer.fields_values=null;
      }).catch(err=>{console.error(err);toastr.error("error al obtener los campos del servicio")})
    },

    async cloneOffer(){

      let valuesArray=[];

      if(this.fields.length){
        let continueCreation=true;

        await this.fields.map((field, i)=>{
          if (!this.fieldsValues[i]||this.fieldsValues[i]==""){
            continueCreation=false;
          }
          else valuesArray.push({
            "field_id":field.id,
            "value":this.fieldsValues[i]
          });
        });

        if(!continueCreation) {
          return toastr.error('Debe llenar los campos referentes al servicio seleccionado');
        }

      }else if(this.offer.fields_values.length){
        if(this.offer.fields_values.length){
          for(let i=0; i< this.offer.fields_values.length; i++){
            if(!this.offer.fields_values[i].value){
              toastr.error('Debe llenar los campos referentes al servicio seleccionado');
              return false;
            }
            else {
              let {field_id,value}=this.offer.fields_values[i];
              valuesArray.push({
                field_id,
                value
              });
            }
          }
        }
        else return toastr.error('Debe llenar los campos referentes al servicio seleccionado');
      }

      let fd= new FormData();
      fd.append("company", this.offer.company_name);
      fd.append("service", this.offer.service);
      fd.append("benefits", this.offer.benefits);

      if(this.offer.departments) 
        if(JSON.parse(this.offer.departments)&&JSON.parse(this.offer.departments).length)
          fd.append("departments", this.offer.departments);

      if(this.offer.municipalities) 
        if(JSON.parse(this.offer.municipalities)&&JSON.parse(this.offer.municipalities).length)
          fd.append("municipalities", this.offer.municipalities);
          
      fd.append("tariff", parseInt(this.offer.tariff));
      if(this.offer.type) fd.append("type", this.offer.type);
      fd.append("points", this.offer.points);
      fd.append("fields_values", valuesArray.length?JSON.stringify(valuesArray):null);

      axios.post(baseUrl+"/api/offer", fd)
      .then(res=>{
        console.log("RESPONSE FROM SERVER ",res);

        toastr.success("Oferta clonada con éxito");
        setTimeout(function(){
          window.location.reload();
        }, 2000);
      })
      .catch(err=>{
        if(err.response.status===403){
          window.location.replace(baseUrl+"/login");
        }
        console.log("ERROR FROM SERVER ",err.response);
        if (err.response.data.errorMessage){
          toastr.error(err.response.data.errorMessage);
        }else {
          let allErrors = err.response.data;
          for (var errorkey in allErrors) {
            if (allErrors[errorkey]){
              for (var error of allErrors[errorkey]) {
                toastr.error(error);
              }
            }
          }
        }
      });
    }
  }
}
</script>
