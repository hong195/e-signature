<template>
  <div>
    <v-dialog v-model="dialog" eager max-width="520px" persistent>
      <v-card>
        <v-card-title>
          <h3 class="display-1">
            Пожалуйста, вырезайте фото
          </h3>
          <v-spacer />
          <v-btn small type="button" icon @click="clearImg">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="text-center">
          <vue-avatar
            ref="vueavatar"
            :width="400"
            :height="400"
          />
        </v-card-text>
        <v-card-actions class="px-6">
          <v-spacer />
          <v-btn color="success" small @click="saveClicked">
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
  import { VueAvatar } from 'vue-avatar-editor-improved'
  export default {
    components: {
      VueAvatar,
    },
    data: function data () {
      return {
        dialog: false,
      }
    },

    methods: {
      saveClicked: function saveClicked () {
        var img = this.$refs.vueavatar.getImageScaled()
        // this.$refs.image.src = img.toDataURL()
        console.log(img)
        this.$emit('input', img.toDataURL())
        this.dialog = false
      },
      clearImg () {
        this.dialog = false
        this.$emit('input', null)
      },
    },
  }
</script>
