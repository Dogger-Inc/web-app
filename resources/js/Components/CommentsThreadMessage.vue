<script setup>
import { ArrowUturnRightIcon, EllipsisVerticalIcon, PencilIcon } from '@heroicons/vue/24/solid';
import dayjs from 'dayjs';
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineEmits(['edit', 'answer']);
defineProps({
    comment: {
        type: Object,
        required: true,
    }
})

const page = usePage();
const currentUser = computed(() => page.props.auth.user);
</script>

<template>
    <div class="flex flex-col gap-2 w-full text-sm group">
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
            <span class="bg-gray-200 h-8 w-8 rounded-full min-w-8"></span>
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
                <MenuButton class="invisible border rounded shadow p-2 group-hover:visible">
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
                    <MenuItems class="absolute top-8 left-0 z-10 mt-2 w-24 origin-top-right rounded-md bg-gray-50 py-1 shadow-lg">
                        <MenuItem>
                            <div
                                class="flex flex-row items-center gap-2 px-4 py-2 text-xs cursor-pointer hover:bg-gray-100"
                                @click="() => $emit('anwser', comment)"
                            >
                                <ArrowUturnRightIcon class="w-3 h-3" />
                                Answer
                            </div>
                        </MenuItem>
                        <MenuItem v-if="currentUser.id === comment.user_id">
                            <div
                                class="flex flex-row items-center gap-2 px-4 py-2 text-xs cursor-pointer hover:bg-gray-100"
                                @click="() => $emit('edit', comment)"
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
</template>
