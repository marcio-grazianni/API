<template>
  <div class="board d-flex flex-grow-1 flex-row">
    <div v-for="column in columns" :key="column.key" class="board-column pa-2">
      <h5>{{ column.title }}</h5>
      <div class="board-column-actions">
        <v-btn icon small color="primary" @click="column.isAddVisible = !column.isAddVisible">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-btn icon small color="error" @click="deleteColumnDialog = true;selectedColumn=column">
          <v-icon small>mdi-delete</v-icon>
        </v-btn>
      </div>

      <v-card v-show="column.isAddVisible" class="pa-2 my-2">
        <v-text-field
          v-model="column.cardTitle"
          label="Add new card"
          autofocus
          @keyup.enter="addCard(column)"
          @keyup.esc="column.isAddVisible = false"
        ></v-text-field>
        <v-textarea
          v-model="column.cardDescription"
          class="px-2 py-1"
          solo
          flat
          label="Description"
          hide-details
        ></v-textarea>
        <div class="d-flex flex-md-row flex-column">
          <v-btn class="flex-grow-1 ma-1" small @click="column.isAddVisible = !column.isAddVisible">
            Cancel
          </v-btn>
          <v-btn class="flex-grow-1 ma-1" small color="primary" @click="addCard(column)">Add</v-btn>
        </div>
      </v-card>

      <vue-draggable
        v-model="column.cards"
        :delay="sortDelay"
        v-bind="dragOptions"
        animation="250"
        class="board-group"
        group="cardsGroup"
        @change="column.callback"
      >
        <board-card
          v-for="card in column.cards"
          :key="card.id"
          :card="card"
          class="board-item my-2 pa-2"
          @delete="showDelete(card)"
          @edit="showEdit(card)"
        />
      </vue-draggable>

    </div>
    <add-new-column @created="init"/>
    <generate-token-button/>
    <export-button/>
    <v-dialog v-model="editDialog" width="600">
      <v-card>
        <v-card-title class="pa-2">
          <span>Edit</span>
          <v-spacer></v-spacer>
          <v-btn icon @click="editDialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>

        <v-divider></v-divider>

        <div>
          <v-text-field
            v-model="title"
            class="px-2 py-1"
            solo
            flat
            label="Title"
            autofocus
            hide-details
            @keyup.enter="update"
          ></v-text-field>

          <v-divider></v-divider>

          <v-textarea
            v-model="description"
            class="px-2 py-1"
            solo
            flat
            label="Description"
            hide-details
          ></v-textarea>
        </div>

        <v-divider></v-divider>

        <v-card-actions class="pa-2">
          <v-btn outlined @click="editDialog = false">Cancel</v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="update">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">Delete</v-card-title>
        <v-card-text>Do you really want to delete?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="deleteDialog = false">Cancel</v-btn>
          <v-btn color="error" @click="deleteCard()">Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="deleteColumnDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">Delete</v-card-title>
        <v-card-text>Do you really want to delete?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="deleteColumnDialog = false">Cancel</v-btn>
          <v-btn color="error" @click="deleteColumn()">Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import VueDraggable from 'vuedraggable'
import BoardCard from '../components/BoardCard'
import axios from 'axios'
import AddNewColumn from '@/components/AddNewColumn'
import ExportButton from '@/components/ExportButton'
import GenerateTokenButton from '@/components/GenerateTokenButton'

export default {
  components: {
    GenerateTokenButton,
    ExportButton,
    AddNewColumn,
    VueDraggable,
    BoardCard
  },
  data() {
    return {
      newColumnDialog: false,
      deleteColumnDialog: false,
      selectedColumn: null,
      sortDelay: 0,
      columns: [],
      editDialog: false,
      cardToEdit: null,
      title: '',
      description: '',
      deleteDialog: false,
      cardToDelete: null
    }
  },
  computed: {
    dragOptions() {
      return {
        animation: 200,
        group: 'description',
        disabled: false,
        ghostClass: 'ghost'
      }
    }
  },
  created() {
    this.init()
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  methods: {
    init() {
      axios.get('columns').then((response) => {
        this.columns = response.data.map((item, index) => {
          return { ...item, isAddVisible: false, callback: (evt) => this.changeState(evt, index) }
        })
      })
    },
    addCard(column) {
      const form = {
        column_id: column.id,
        title: column.cardTitle,
        description: column.cardDescription
      }

      axios.post('cards', form).then((response) => {
        column.cards.push(response.data)
        column.isAddVisible = false
      })
    },
    showEdit(card) {
      this.cardToEdit = card
      this.title = card.title
      this.description = card.description
      this.editDialog = true
    },
    update() {
      const form = {
        title: this.title,
        description: this.description
      }

      axios.put('cards/' + this.cardToEdit.id, form).then((response) => {

        const card = response.data
        const { cards } = this.columns.find((t) => t.id === card.column_id)

        const editedIndex = cards.map((card) => card.id).indexOf(card.id)
        const editedItem = Object.assign({}, card)

        console.log(editedIndex)

        Object.assign(cards[editedIndex], editedItem)
      })
      this.editDialog = false
    },
    showDelete(card) {
      this.cardToDelete = card
      this.deleteDialog = true
    },
    deleteCard() {
      axios.delete('cards/' + this.cardToDelete.id).then(() => {
        const { cards } = this.columns.find((t) => t.id === this.cardToDelete.column_id)

        const editedIndex = cards.map((card) => card.id).indexOf(this.cardToDelete.id)

        cards.splice(editedIndex, 1)
      })
      this.deleteDialog = false
    },
    deleteColumn() {
      axios.delete('columns/' + this.selectedColumn.id).then(() => {
        this.init()
        this.deleteColumnDialog = false
      })
    },
    changeState: function (evt, colIndex) {
      if (evt.added || evt.moved) {
        const column = this.columns[colIndex]

        for (let i = 0; i < column.cards.length; i++) {
          column.cards[i].order = i
          column.cards[i].column_id = column.id
        }

        axios.post('cards/update/bulk',{ cards: column.cards })
      }
    },
    handleResize() {
      if (window.innerWidth < 900) {
        this.sortDelay = 200
      } else {
        this.sortDelay = 0
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.ghost {
  opacity: 0.5;
  background: var(--v-primary-lighten1) !important;
}

.board {
  display: flex;
  overflow-x: scroll;
  height: 85vh;

  .board-column {
    position: relative;
    display: flex;
    flex: 1;
    flex-direction: column;
    min-width: 180px;

    &-actions {
      position: absolute;
      top: 12px;
      right: 6px;
    }
  }

  .board-group {
    min-height: 100%;
  }

  .board-item {
    position: relative;
    min-height: 54px;
    transition: transform 0.2s;
    cursor: pointer;

    > a {
      display: block;
      padding: 8px;
    }

    &:hover {
      transform: translateY(-6px);
    }

    &.sortable-chosen {
      cursor: all-scroll;
    }
  }
}

.v-application--is-rtl {
  .board-column-actions {
    left: 6px;
    right: auto;
  }
}
</style>
