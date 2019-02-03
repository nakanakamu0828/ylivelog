<template>
  <app-layout>
    <alert
      :type="alertType || 'info'"
      :message="alertMessage"
      v-on:close="closeSuccessAlert"
    />
    <div class="flex flex-row justify-center">
        
      <div class="w-full sm:max-w-sm pt-5">
        <message-box
          title="ご利用に当たる注意点"
          message="Youtube Liveを配信しているGoogleアカウントのみチャットログを取得することが可能です"
        />

        <div
          class="bg-white shadow-md rounded mt-5 mx-1 px-2 sm:px-4 pt-6 pb-8 mb-4"
          v-if="isLoggined"
        >

          <form
            class="mb-4"
            @submit.prevent="submit"
          >
            <div class="flex items-center border-b border-b-2 border-teal py-2">
              <input
                class="appearance-none bg-transparent border-none w-full text-grey-darker mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="text"
                placeholder="Youtube Video ID"
                autocomplete="off"
                v-model="form.id"
                :disabled="video"
                :class="{ 'border-red': $v.form.id.$error }"
              >
              <button
                class="flex-no-shrink bg-teal hover:bg-teal-dark border-teal hover:border-teal-dark text-sm border-4 text-white py-1 px-2 rounded"
                type="submit"
                :class="{ 'opacity-50 cursor-not-allowed': video }"
                :disabled="video"
              >
                Submit
              </button>
            </div>
            <div class="text-grey text-xs mt-2">
              "https://www.youtube.com/watch?v=xxxxxx" の "xxxxxx"の部分を入力してください。
            </div>
            <div class="text-red text-sm mt-2" v-if="$v.form.id.$error && !$v.form.id.required">
              youtubeのVideo IDは必須です。
            </div>
          </form>

          <video-card
            v-if="video"
            :video="video"
          />

          <chat-card
            v-for="post in posts" :key="post.id"
            :post="post"
          />

        </div>
        <div
          v-else
          class="text-center mt-5 pt-6 pb-8"
        >
          <google-login-button
            v-on:click="googleLogin"
          />
        </div>

      </div>

    </div>
    
  </app-layout>
</template>

<script>
import http from '~/plugins/http.js'

import Alert from '~/components/atoms/alert'
import MessageBox from '~/components/atoms/message-box'
import GoogleLoginButton from '~/components/molecules/google-login-button'
import VideoCard from '~/components/molecules/cards/video-card'
import ChatCard from '~/components/molecules/cards/chat-card'
import AppLayout from '~/components/templates/app-layout'

import { required } from 'vuelidate/lib/validators'

export default {
  components: { AppLayout, GoogleLoginButton, Alert, VideoCard, ChatCard, MessageBox },
  head: {
    title: {
      inner: process.env.MIX_APP_NAME,
    },
    meta: [
      { name: 'description', content: process.env.MIX_APP_DESCRIPTION },
    ]
  },
  data: () => ({
    form: {
        id: '',
        nextPageToken: null
    },
    alertType: null,
    alertMessage: null,
    intervalId: null,
    video: null,
    posts: [],
  }),
  validations: {
    form: {
      id: {
        required
      }
    }
  },
  methods: {
    googleLogin() {
      location.href = '/oauth/google'
    },
    closeSuccessAlert() {
      this.alertMessage = null
    },
    async submit() {
      if (!this.video) {
        this.$v.$touch()
        if (this.$v.$invalid) return

        this.$store.dispatch('setLoading', true)
      }

      const response = await http.post('api/youtube/livechats', this.form)
      this.$store.dispatch('setLoading', false)
      if (!response.ok) {
        this.alertType = 'error';
        this.alertMessage = {
          title: 'Liveチャットデータ取得失敗',
          description: 'Youtube Liveのチャットデータ取得に失敗しました。'
        }
        return
      }
      console.log(response)
      this.video = {
        title: response.data.title,
        imageUrl: response.data.image_url
      }
      this.form.nextPageToken = response.data.nextPageToken
      this.posts = [...response.data.posts.slice().reverse(), ...this.posts]

      setTimeout(this.submit, 5000);
    },
  },
  computed: {
    isLoggined () {
      return this.$store.getters['auth/isLoggined']
    },
    user () {
      return this.$store.getters['auth/user']
    }
  }
}
</script>