<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          class="mt-2"
          color="primary"
          small
          outlined
          v-bind="attrs"
          v-on="on"
        >
          Add new column
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          Create a new column
        </v-card-title>

        <v-card-text>
          <v-text-field v-model="title" label="Column title" @keyup.enter="save"/>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="error"
            text
            @click="dialog=false"
          >
            Cancel
          </v-btn>
          <v-btn
            color="primary"
            text
            @click="save"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import axios from 'axios'

export default {
  data() {
    return {
      dialog: false,
      title: ''
    }
  },
  methods: {
    save() {
      axios.post('columns', { title: this.title }).then(() => {
        this.title = ''
        this.$emit('created')
        this.dialog = false
      })
    }
  }
}
</script>
