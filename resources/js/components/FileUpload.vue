<script setup lang="ts">
import { ref } from "vue";
import { X, Upload, Link } from "lucide-vue-next";

const props = defineProps<{
	multiple?: boolean;
}>();

const emit = defineEmits<{
	(e: "update:files", value: File[]): void;
}>();

const files = ref<File[]>([]);

const handleFiles = (newFiles: FileList | null) => {
	if (!newFiles) return;

	const selected = Array.from(newFiles);

	if (props.multiple) {
		files.value = [...files.value, ...selected];
	} else {
		files.value = selected.slice(0, 1);
	}

	emit("update:files", files.value);
};

const onDrop = (e: DragEvent) => {
	e.preventDefault();
	if (e.dataTransfer) {
		handleFiles(e.dataTransfer.files);
	}
};

const onRemove = (index: number) => {
	files.value.splice(index, 1);
	emit("update:files", files.value);
};

// Helper for preview
const getPreviewUrl = (file: File) => {
	if (file && file.type.startsWith("image/")) {
		return URL.createObjectURL(file);
	}
	return null;
};
</script>

<template>
	<div class="flex gap-3 flex-wrap">
		<!-- File Previews -->
		<div v-for="(file, index) in files" :key="index"
			class="relative w-40 h-32 border rounded-md flex flex-col items-center justify-center overflow-hidden">
			<!-- Image Preview -->
			<img v-if="getPreviewUrl(file)" :src="getPreviewUrl(file)!" alt="preview"
				class="w-full h-20 object-cover" />

			<!-- File Name -->
			<span class="text-xs text-gray-700 truncate px-1 mt-1">
				{{ file.name }}
			</span>

			<!-- Remove Button -->
			<button type="button" class="absolute top-1 right-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 cursor-pointer"
				@click.stop="onRemove(index)">
				<X class="w-4 h-4 p-[2px]" />
			</button>
		</div>

		<!-- Upload Area -->
		<div class="w-40 h-32 flex flex-col items-center justify-center gap-1 border-2 border-dashed border-gray-400 rounded-md text-center hover:border-blue-400 transition cursor-pointer"
			@dragover.prevent @drop="onDrop" @click="$refs.fileInput?.click()">
			<!-- Upload Icon -->
			 <Upload class="w-8 h-8 text-green-400" />
		
			<!-- Drag Text -->
			<small class="text-gray-500 font-medium text-xs">Drag & drop files here</small>

			<!-- OR Separator -->
			<span class="text-gray-400 text-xs">or</span>

			<!-- Browse Button -->
			<button type="button"
				class="px-2 py-1 border border-blue-500 text-blue-500 text-xs rounded hover:bg-blue-50 transition cursor-pointer">
				<Link class="w-3 h-3 inline-block mr-1" /> Browse
			</button>

			<!-- Hidden Input -->
			<input type="file" :multiple="multiple" ref="fileInput" class="hidden"
				@change="handleFiles(($event.target as HTMLInputElement).files)" 
				accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xlsx"
			/>
		</div>
	</div>
</template>
