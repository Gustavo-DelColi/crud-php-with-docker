<template>
  <div>
    <VContainer>
      <h1>Conexão com Backend PHP</h1>
      <button @click="fetchPersons">Testar Conexão</button>
      <p>{{ message }}</p>
      <VBtn @click="addDialog = true">Adicionar</VBtn>
      <div v-for="(person, index) in persons" key="index" class="d-flex">
        <VCol class="d-flex ga-3 align-center">
          <VTextField
            variant="outlined"
            label="Nome"
            density="default"
            hide-details
            v-model="person.name"
          ></VTextField>
          <VTextField
            variant="outlined"
            label="Telefone"
            density="default"
            hide-details
            v-model="person.phone"
          ></VTextField>
          <VTextField
            variant="outlined"
            label="Email"
            density="default"
            v-model="person.email"
            hide-details
          ></VTextField>

          <div class="d-flex ga-2">
            <VBtn icon="mdi-trash-can-outline" color="error"></VBtn>
            <VBtn icon="mdi-pencil" color="info" @click="editPerson(person)"></VBtn>
          </div>
        </VCol>
        <div class="d-flex justify-center"></div>
      </div>

      {{ teste }}
      {{ addok }}
    </VContainer>
    <VDialog
      v-model="addDialog"
      max-width="500px
    "
    >
      <VCard >
      <VCol>
          <VTextField
            variant="outlined"
            label="Nome"
            density="default"
            hide-details
            v-model="add.name"
          ></VTextField>
        </VCol>
        <VCol>
          <VTextField
            variant="outlined"
            label="Telefone"
            density="default"
            hide-details
            v-model="add.phone"
          ></VTextField>
        </VCol>
          <VCol>
          <VTextField
            variant="outlined"
            label="Email"
            density="default"
            v-model="add.email"
            hide-details
          ></VTextField>
        </VCol>
   
        <VCol class="pt-3 d-flex ga-3">
          <VBtn color="info" @click="addPerson">Salvar</VBtn>
          <VBtn color="error" @click="addDialog = false">Cancelar</VBtn>
        </VCol>
      </VCard>
    </VDialog>

    <VDialog
      v-model="editDialog"
      max-width="500px
    "
    >
      <VCard >
      <VCol>
          <VTextField
            variant="outlined"
            label="Nome"
            density="default"
            hide-details
            v-model="edit.name"
          ></VTextField>
        </VCol>
        <VCol>
          <VTextField
            variant="outlined"
            label="Telefone"
            density="default"
            hide-details
            v-model="edit.phone"
          ></VTextField>
        </VCol>
          <VCol>
          <VTextField
            variant="outlined"
            label="Email"
            density="default"
            v-model="edit.email"
            hide-details
          ></VTextField>
        </VCol>
   
        <VCol class="pt-3 d-flex ga-3">
          <VBtn color="info">Salvar</VBtn>
          <VBtn color="error" @click="editDialog = false">Cancelar</VBtn>
        </VCol>
      </VCard>
    </VDialog>
  </div>
</template>

<script>
import axios from "axios";
import { API_ADVISE } from "./../config";
export default {
  data() {
    return {
      message: "",
      addDialog: false,
      editDialog: false,
      edit:"",
      add: {
        name: "",
        phone: "",
        email: "",
      },
      teste: [],
      addok:"",
      persons: [
        {
          id:'0',
          name: "Gustavo",
          phone: "43 99264382",
          email: "asdasd@asdad.com",
        },
        {
          id:'1',
          name: "Tayla",
          phone: "43 99264382",
          email: "asdasd@asdad.com",
        },
      ],
    };
  },
  methods: {
    fetchData() {
      axios
        .get(API_ADVISE)
        .then((response) => {
          this.message = response.data;
        })
        .catch((error) => {
          this.message = "Erro: " + error.message;
        });
    },
    fetchPersons() {
      axios
        .get(`${API_ADVISE}/controller/person.php`)  // Ajuste a URL conforme necessário
        .then((response) => {
          console.log("Resposta recebida:", response);
          this.teste = response.data;  // Armazena os dados no array
        })
        .catch((error) => {
          console.error("Erro ao buscar dados:", error);
        });
    },

    addPerson() {
      axios
        .post(`${API_ADVISE}/index.php?route=person/add`, this.add)  // Ajuste a URL conforme necessário
        .then((response) => {
          this.addok = response.data;  // Armazena os dados no array
          console.log("Pessoa adicionada com sucesso:", response.data);
        })
        .catch((error) => {
          console.error("Erro ao buscar dados:", error);
        });
    },
    editPerson(person){
      this.edit = person;
      this.editDialog = true;
    
    }
  },
};
</script>
