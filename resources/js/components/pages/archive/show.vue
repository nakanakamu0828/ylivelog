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
          title="このページの説明"
          :message="description"
        />
        <div class="mb-10"></div>
      
        <div
          class="bg-white shadow-md rounded mt-5 mx-1 px-2 sm:px-4 pt-6 pb-8 mb-4"
          v-if="video"
        >

          <video-card
            :video="video"
          />

          <chat-card
            v-for="post in posts" :key="post.id"
            :post="post"
          />


          <div 
              v-if="next"
              class="my-10 text-center"
          >
            <button
              class="w-full bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-full"
              @click="loadPosts"
            >
              次を読み込む
            </button>
          </div>
        </div>
        
      </div>
    </div>
    
  </app-layout>
</template>

<script>
import http from '~/plugins/http.js'

import Alert from '~/components/atoms/alert'
import MessageBox from '~/components/atoms/message-box'
import VideoCard from '~/components/molecules/cards/video-card'
import ChatCard from '~/components/molecules/cards/chat-card'
import AppLayout from '~/components/templates/app-layout'


export default {
  components: { Alert, MessageBox, VideoCard, ChatCard, AppLayout },
  head: {
    title: function () {
      return {
        inner: this.title
      }
    },
    meta:function () {
      return [
        { id: 'description', name: 'description', content: this.description },
      ]
    }
  },
  data: () => ({
    title: 'チャットアーカイブ',
    description: '記録した動画のチャットアーカイブ一覧を表示します',


    video: null,
    next: null,
    posts: [],

    alertType: null,
    alertMessage: null,

  }),
  methods: {
    async loadPosts() {
      if (!this.next) return

      const response = await http.get(`/api/video/${this.video.id}/chats?page=${this.next}`)
      if (!response.ok) {
        this.alertType = 'error';
        this.alertMessage = {
          title: 'データ取得失敗',
          description: 'Chatデータ取得に失敗しました。'
        }
        return
      }

      this.next = response.data.next
      this.posts = [...this.posts, ...response.data.posts.data]
    },
    closeSuccessAlert() {
      this.alertMessage = null
    },
  },
  beforeRouteEnter (to, from, next) {
    http.get(`/api/video/${to.params.id}`)
      .then(res => {
        next(vm => {
          vm.video = res.data.video
          vm.posts = res.data.posts.data
          vm.next = res.data.next
        })
      })
      .catch(e => {
        next(false)
      })
  }
}
</script>