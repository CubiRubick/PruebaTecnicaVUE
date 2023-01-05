<template>
  <div class="about">
    <v-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            Id
          </th>
          <th class="text-left">
            estatus
          </th>
          <th class="text-left">
            nombre
          </th>
          <th class="text-left">
            sexo
          </th>
          <th class="text-left">
            fecha de nacimiento
          </th>
          <th class="text-left">
            edad
          </th>
          <th class="text-left">
            telefono
          </th>
          <th class="text-left">
            correo
          </th>
          <th class="text-left">
            puesto
          </th>
          <th class="text-left">
            departamento
          </th>
          <th class="text-left">
            turno
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in usuarios"
          :key="item.id"
        >
          <td>{{ item.id }}</td>
          <td>{{ item.estatus }}</td>
          <td>{{ item.nombre }}</td>
          <td>{{ item.sexo }}</td>
          <td>{{ item.fechanacimiento }}</td>
          <td>{{ item.edad }}</td>
          <td>{{ item.telefono }}</td>
          <td>{{ item.correo }}</td>
          <td>{{ item.puesto }}</td>
          <td>{{ item.departamento }}</td>
          <td>{{ item.turno }}</td>
          <td>
              <RouterLink to="/">Editar</RouterLink>
              <RouterLink to="/">Borrar</RouterLink>
          </td>
        </tr>
      </tbody>
    </template>
  </v-table>
  </div>
</template>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
<script>
export default{
    data(){
      return{
        usuarios:[]
      }
    },

    created:function(){
      this.consultaprueba();

    },
    methods:{
      consultaprueba(){
        fetch('http://localhost/pruebacrud/crud.php')
        .then(respuesta=>respuesta.json())
        .then((datosRespuesta)=>{
        console.log(datosRespuesta)
        this.usuarios = []
        if(typeof datosRespuesta[0].success==='undefined'){
          this.usuarios=datosRespuesta;
        }
      })
      .catch(console.log)
      }
    }
  }
</script>
