<script setup>
import { PaperAirplaneIcon, XCircleIcon } from '@heroicons/vue/24/solid';
import CommentsThreadMessage from '@/Components/CommentsThreadMessage.vue';
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const props = defineProps({
    comments: {
        type: Array,
        default: () => [],
    },
    commentableId: {
        type: Number,
        required: true,
    },
    addPath: {
        type: String,
        required: true,
    }
})

const { t } = useI18n();

const answerToComment = ref();
const commentToEdit = ref();
const addCommentForm = useForm({
    content: '',
    reply_to: ''
})

const editCommentForm = useForm({
    content: '',
})

const thread = ref();

const handleSubmitComment = () => {
    if (commentToEdit.value) {
        editCommentForm.patch(route('dashboard.comments.editComment.patch', commentToEdit.value.id), {
            onStart: () => editCommentForm.clearErrors(),
            onSuccess: () => editCommentForm.reset(),
        });
        commentToEdit.value = undefined;
        return;
    }

    addCommentForm.post(route(props.addPath, props.commentableId), {
        onStart: () => addCommentForm.clearErrors(),
        onSuccess: () => {
            thread.value.scrollTop = thread.value.scrollHeight;
            addCommentForm.reset()
        }
    });
}

const handleEditMessage = (comment) => {
    answerToComment.value = undefined;
    commentToEdit.value = comment;
    editCommentForm.content = comment.content;
}

const handleCancelEditMessage = () => {
    commentToEdit.value = undefined;
    editCommentForm.content = '';
}

const handleAnswerMessage = (comment) => {
    commentToEdit.value = undefined;
    answerToComment.value = comment;
    addCommentForm.reply_to = comment.id;
}

const handleCancelAnswerMessage = () => {
    answerToComment.value = undefined;
    addCommentForm.reply_to = '';
}

onMounted(() => {
    if (thread.value) {
        thread.value.scrollTop = thread.value.scrollHeight;
    }
})
</script>

<template>
    <div ref="thread" class="space-y-4 max-h-96 overflow-y-auto pr-3 relative">
        <CommentsThreadMessage
            v-for="comment in comments"
            :key="comment.id"
            :comment="comment"
            @edit="handleEditMessage"
            @anwser="handleAnswerMessage"
        />
    </div>

    <form
        class="flex flex-col gap-2"
        :class="{
            'bg-dogger-orange-100 rounded p-2': answerToComment || commentToEdit
        }"
        @submit.prevent="handleSubmitComment"
    >
        <div v-if="answerToComment" class="flex flex-row justify-between items-center">
            <div class="text-xs opacity-40">
                <span class="underline">Reply to : </span>
                <span class="italic font-semibold">{{ answerToComment.user.fullname }} said </span>
                <span class="italic">{{ answerToComment.content }}</span>
            </div>
            <XCircleIcon class="w-5 h-5 text-gray-400 cursor-pointer" @click="handleCancelAnswerMessage" />
        </div>
        <div v-if="commentToEdit" class="flex flex-row justify-between items-center">
            <div class="text-xs opacity-40">
                <span class="underline">Edit : </span>
                <span class="italic">{{ commentToEdit.content }}</span>
            </div>
            <XCircleIcon class="w-5 h-5 text-gray-400 cursor-pointer" @click="handleCancelEditMessage" />
        </div>
        <div class="flex flex-row items-center gap-2">
            <input
                v-if="!commentToEdit"
                v-model="addCommentForm.content"
                type="text"
                name="add-comment"
                placeholder="Add comment"
                class="w-full border p-2 rounded"
            />
            <input
                v-else
                v-model="editCommentForm.content"
                type="text"
                name="edit-comment"
                placeholder="Edit comment"
                class="w-full border p-2 rounded"
            />
            <button class="bg-dogger-orange-500 text-white h-10 w-10 flex items-center justify-center rounded">
                <PaperAirplaneIcon class="h-5 w-5" />
            </button>
        </div>
    </form>
</template>
