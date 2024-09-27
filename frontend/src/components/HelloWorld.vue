<template>
  <div>
    <VContainer>
      <button @click="fetchData">Testar Conexão</button>
      <p>{{ message }}</p>
      <br>
      <h1>Crud de cadastro de pessoas simples.</h1>
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
            <VBtn
              icon="mdi-trash-can-outline"
              color="error"
              @click="deletePerson(person)"
            ></VBtn>
            <VBtn icon="mdi-pencil" color="info" @click="editPerson(person)"></VBtn>
          </div>
        </VCol>
        <div class="d-flex justify-center"></div>
      </div>
    </VContainer>
    <VDialog
      v-model="addDialog"
      max-width="500px
    "
    >
      <VCard>
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
      <VCard>
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
          <VBtn color="info" @click="saveEdit">Salvar</VBtn>
          <VBtn color="error" @click="editDialog = false">Cancelar</VBtn>
        </VCol>
      </VCard>
    </VDialog>

    <VDialog
      v-model="deleteDialog"
      max-width="500px
    "
    >
      <VCard>
        <VCardTitle> Deseja realmente apagar o cadastro?</VCardTitle>

        <VCol class="pt-3 d-flex ga-3">
          <VBtn color="info" @click="saveDelete">Sim</VBtn>
          <VBtn color="error" @click="deleteDialog = false">Não</VBtn>
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
      deleteDialog: false,
      edit: "",
      delete: "",
      add: {
        name: "",
        phone: "",
        email: "",
      },

      persons: [],
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
        .get(`${API_ADVISE}/controller/person.php`)
        .then((response) => {
          this.persons = response.data; 
        })
        .catch((error) => {
          console.error("Erro ao buscar dados:", error);
        });
    },

    addPerson() {
      axios
        .post(`${API_ADVISE}/controller/addPerson.php`, this.add)
        .catch((error) => {
          console.error("Erro ao buscar dados:", error);
        })
        .finally(() => {
          this.addDialog = false;
          this.fetchPersons();
        });
    },
    editPerson(person) {
      this.edit = person;
      this.editDialog = true;
    },

    saveEdit() {
      axios
        .post(`${API_ADVISE}/controller/updatePerson.php`, this.edit)
        .catch((error) => {
          console.error("Erro ao buscar dados:", error);
        })
        .finally(() => {
          this.fetchPersons();
          this.editDialog = false;
        });
    },

    deletePerson(person) {
      this.delete = person;
      this.deleteDialog = true;
    },

    saveDelete() {
      axios
        .post(`${API_ADVISE}/controller/deletePerson.php`, this.delete)
        .catch((error) => {
          console.error("Erro ao buscar dados:", error);
        })
        .finally(() => {
          this.fetchPersons();
          this.deleteDialog = false;
        });
    },
  },
  mounted() {
    this.fetchPersons();
  },
};
</script>
