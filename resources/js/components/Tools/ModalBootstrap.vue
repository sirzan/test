<template>
  <slot :openModal="openModal"></slot>

  <div
    class="modal fade"
    ref="modal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
    data-bs-keyboard="false"
    data-bs-backdrop="static"
  >
    <div
      class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
      :class="size && size"
    >
      <div class="modal-content">
        <div class="modal-header">
          <i class="fas fa-solid fa-xmark" @click="closeModal"></i>
        </div>
        <div class="modal-body pt-0 px-4">
          <slot name="body">Modal body content goes here.</slot>

          <div class="form-actions row">
            <div class="col-md-4">
              <slot name="btn"></slot>
            </div>
            <div class="col-md-8 text-end">
              <button
                type="button"
                v-if="ShowCancel"
                class="btn btn-none"
                @click="closeModal"
              >
                Cancelar
              </button>
              <slot name="submit"></slot>
            </div>
          </div>
        </div>
        <div class="modal-footer" v-if="ShowFooter">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
    
    <script setup>
import { ref, onMounted, onUnmounted, defineExpose } from "vue";
import * as bootstrap from "bootstrap";

const props = defineProps({
  size: {
    type: String,
  },
  ShowCancel: {
    type: Boolean,
    default: true,
  },
  ShowFooter: {
    type: Boolean,
    default: false,
  },
});

const modal = ref(null);
const modalTitle = ref("Modal Title");

let modalInstance = null;

// Inicializar el modal cuando el componente se monta
onMounted(() => {
  modalInstance = new bootstrap.Modal(modal.value);
});

// Limpiar la instancia del modal cuando el componente se desmonta
onUnmounted(() => {
  modalInstance.dispose();
});

const openModal = () => {
  modalInstance.show();
};

const closeModal = () => {
  modalInstance.hide();
};

defineExpose({
  openModal,
  closeModal,
});
</script>
    

    