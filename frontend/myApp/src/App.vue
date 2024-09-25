<template>
  <div>
    <h1>Conexão com Backend PHP</h1>
    <button @click="fetchData">Testar Conexão</button>
    <p>{{ message }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      message: ''
    };
  },
  methods: {
    fetchData() {
      axios.get('http://localhost:8080')
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
