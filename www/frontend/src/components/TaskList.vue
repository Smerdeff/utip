<template>
    <div>
        <b-table show-empty striped hover :items="tasks.data" :fields="fields" primary-key="id">
            <template v-slot:cell(actions)="row">
                <b-button size="sm" @click="editTask(row.item)" class="mr-1">
                    ...
                </b-button>
                <b-button variant="danger" size="sm" @click="deleteTask(row.item)" class="mr-1">
                    x
                </b-button>
            </template>
        </b-table>
    </div>

</template>


<script>
  import {mapActions} from 'vuex';

  export default {
    name: "TaskList",
    props: ['tasks'],
    methods: Object.assign({},
      // mapActions(['DESTROY_TASKS']),
      {
        editTask(item, index, button) {
          this.$store.dispatch('DESTROY_TASKS', item)
        },

        deleteTask(item, index, button) {
          this.$bvModal.msgBoxConfirm(`Вы хотите удалять заявку номер ${item.id}?`)
            .then(value => {
              if (value) {
                this.$store.dispatch('DESTROY_TASKS', item)
              }
            })
          // this.infoModal.title = `Row index: ${index}`
          // this.infoModal.content = JSON.stringify(item, null, 2)
          // this.$root.$emit('bv::show::modal', this.infoModal.id, button)
        },
      }),
    data() {
      return {
        fields: [
          {
            key: 'id',
            sortable: true,
            label: 'Номер'
          },
          {
            key: 'created_at',
            sortable: true,
            label: 'Дата'
          },
          {
            key: 'username',
            label: 'Заявитель'
          },
          {
            key: 'body',
            label: 'Описание',
            // variant: 'danger'
          },
          {
            key: 'actions',
            label: 'Действия'
          }
        ]
      }
    },
  }
  // console.log('tasks')
</script>
