<template>
  <div>
    <h1>Conexão com Backend PHP</h1>
    <button @click="fetchData">Testar Conexão</button>
    <p>{{ message }}</p>
  </div>
</template>

<script>
import axios from 'axios';
import { API_ADVISE } from './config'; 
export default {
  data() {
    return {
      message: ''
    };
  },
  methods: {
    fetchData() {
      axios.get(API_ADVISE)
        .then(response => {
          this.message = response.data;
        })
        .catch(error => {
          this.message = 'Erro: ' + error.message;
        });
    }
  }
};
</script>
