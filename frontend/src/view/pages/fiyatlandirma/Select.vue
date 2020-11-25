<template>
    <div>
        <div class="col-12 float-left p-0 d-block">
            <div
                v-if="getFiyatlandirmaSelect.length > 0"
                class="float-left p-0 form-group col-12"
            >
                <select
                    @input="$emit('input', $event.target.value)"
                    class="form-control"
                    @change="
                        $emit(
                            'fiyatlandirma-change',
                            getFiyatlandirmaSelect.find(
                                cur => +cur.id === +$event.target.value
                            )
                        )
                    "
                >
                    <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                    <option
                        v-for="(value, key) in getFiyatlandirmaSelect"
                        :key="key"
                        :value="value.id"
                        >{{ value.ad }}</option
                    >
                </select>
                <small id="emailHelp" class="form-text">{{
                    $t(selectText)
                }}</small>
            </div>
            <router-link v-else to="/fiyatlandirma-turleri">
                <span class="alert d-block alert-dark">
                    {{ $t("FIYATLANDIRMA.NOT_FOUND_ADD") }}
                </span>
                <small class="form-text">{{ $t(selectText) }}</small>
            </router-link>
        </div>
    </div>
</template>

<script>
import { GET_SELECT as GET_FIYATLANDIRMA_SELECT } from "@/core/services/store/fiyatlandirma.module";
import { mapGetters } from "vuex";
export default {
    name: "FiyatlandirmaSelect",
    props: ["selectText"],
    mounted() {
        this.$store.dispatch(GET_FIYATLANDIRMA_SELECT);
    },
    computed: {
        ...mapGetters(["getFiyatlandirmaSelect"])
    }
};
</script>
