<script setup>
import { PaperAirplaneIcon, ArrowUturnRightIcon, EllipsisVerticalIcon, PencilIcon, XCircleIcon } from '@heroicons/vue/24/solid';
import dayjs from 'dayjs';
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const props = defineProps({
    comments: {
        type: Array,
        default: () => [],
    },
    currentUser: {
        type: Object,
        required: true,
    },
    commentableId: {
        type: Number,
        required: true,
    },
    editPath: {
        type: String,
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
    comment_id: '',
    content: '',
})

const handleSubmitComment = () => {
    if (commentToEdit.value) {
        editCommentForm.patch(route(props.editPath, props.commentableId), {
            onStart: () => editCommentForm.clearErrors(),
            onSuccess: () => editCommentForm.reset(),
        });
        commentToEdit.value = undefined;
        return;
    }

    addCommentForm.post(route(props.addPath, props.commentableId), {
        onStart: () => addCommentForm.clearErrors(),
        onSuccess: () => addCommentForm.reset(),
    });
}

const handleEditMessage = (comment) => {
    answerToComment.value = undefined;
    commentToEdit.value = comment;
    editCommentForm.comment_id = comment.id;
    editCommentForm.content = comment.content;
}

const handleCancelEditMessage = () => {
    commentToEdit.value = undefined;
    editCommentForm.comment_id = '';
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
</script>

<template>
    <div class="space-y-4 h-96 overflow-y-auto pr-3">
        <div
            v-for="comment in comments"
            class="flex flex-col gap-2 w-full text-sm group"
        >
            <div
                v-if="comment.reply_to"
                class="flex flex-row gap-2 text-xs opacity-50 items-center"
                :class="{
                    'justify-end': currentUser.id === comment.user_id,
                    'jusitify-start': currentUser.id !== comment.user_id,
                }"
            >
                <div class="flex flex-row items-center gap-1">
                    <ArrowUturnRightIcon class="w-3 h-3" />
                    <span>{{ comment.reply_to.user.fullname }} : </span>
                </div>
                <span>{{ comment.reply_to.content }}</span>
            </div>
            <div
                class="flex flex-row gap-2 items-start"
                :class="{
                    'flex-row-reverse': currentUser.id === comment.user_id,
                    'flex-row': currentUser.id !== comment.user_id,
                }">
                <span class="bg-gray-200 h-8 w-8 rounded-full"></span>
                <div
                    class="flex flex-col border rounded px-2 py-1"
                    :class="{
                        'justify-end bg-dogger-orange-200 border-dogger-orange-400': currentUser.id === comment.user_id,
                        'jusitify-start bg-gray-100 border-gray-300': currentUser.id !== comment.user_id,
                    }">
                    <span class="font-semibold">{{ comment.user.fullname }}</span>
                    <div class="mb-2">
                        <span>{{ comment.content }}</span>
                        <span
                            v-if="comment.updated_at !== comment.created_at"
                            class="italic opacity-30 text-xs"
                        >
                            (updated)
                        </span>
                    </div>
                    <span class="text-xs opacity-40">{{ dayjs(comment.created_at).format('DD/MM/YYYY HH:mm') }}</span>
                </div>
                <Menu as="div" class="relative inline-flex">
                    <MenuButton class="hidden border rounded shadow p-2 group-hover:block">
                        <span class="sr-only">Open message menu</span>
                        <EllipsisVerticalIcon class="w-3 h-3" />
                    </MenuButton>

                    <Transition
                        enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95"
                    >
                        <MenuItems class="absolute top-8 right-0 z-10 mt-2 w-24 origin-top-right rounded-md bg-gray-50 py-1 shadow-lg">
                            <MenuItem>
                                <div
                                    class="flex flex-row items-center gap-2 px-4 py-2 text-xs cursor-pointer hover:bg-gray-100"
                                    @click="() => handleAnswerMessage(comment)"
                                >
                                    <ArrowUturnRightIcon class="w-3 h-3" />
                                    Answer
                                </div>
                            </MenuItem>
                            <MenuItem v-if="currentUser.id === comment.user_id">
                                <div
                                    class="flex flex-row items-center gap-2 px-4 py-2 text-xs cursor-pointer hover:bg-gray-100"
                                    @click="() => handleEditMessage(comment)"
                                >
                                    <PencilIcon class="w-3 h-3" />
                                    Edit
                                </div>
                            </MenuItem>
                        </MenuItems>
                    </Transition>
                </Menu>
            </div>
        </div>
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
