<template>
  <v-row>
    <v-col cols="3">
      <div class="circledImage--div">
        <v-img class="circledImage" height="120" width="120" cover :src="url" />
      </div>
    </v-col>
    <v-col cols="9">
      <v-list dense>
        <v-list-item>
          <h3>{{ schema.first_name.value }} {{ schema.last_name.value }}</h3>
        </v-list-item>
        <v-list-item>
          <div class="position">
            {{ schema.position.value }}
          </div>
        </v-list-item>
        <v-list-item>
          <v-list-item-icon>
            <v-icon color="#7fb94a">
              mdi-email
            </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="schema.email.value" />
          </v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-icon>
            <v-icon color="#7fb94a">
              mdi-phone
            </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="schema.phone.value" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-col>
  </v-row>
</template>
<script>
  export default {
    name: 'ApplicationPreview',
    props: ['url', 'schema'],
  }
</script>
<style lang="scss" scoped>
.circledImage--div{
  position: relative;
  height: 100%;
}
.circledImage{
  border: 5px solid #7fb94a;
  border-radius: 50%;
  position: absolute;
  top: 18%;
}
.position{
  color: white;
  background: #7fb94a;
  padding: 5px;
  width: 100%;
}
</style>
