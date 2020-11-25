<template>
    <div>
        <!-- download as excel -->
        <b-button @click="downloadXSLX">Excel</b-button>

        <!-- begin :: filter and items per page -->
        <b-row>
            <b-col lg="6" class="my-1">
                <b-form-group
                    label="Filter"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    label-for="filterInput"
                    class="mb-0"
                >
                    <b-input-group size="sm">
                        <b-form-input
                            v-model="filter"
                            type="search"
                            id="filterInput"
                            placeholder="Type to Search"
                        ></b-form-input>
                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''"
                                >Clear</b-button
                            >
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col sm="5" md="6" class="my-1">
                <b-form-group
                    label="Per page"
                    label-cols-sm="6"
                    label-cols-md="4"
                    label-cols-lg="3"
                    label-align-sm="right"
                    label-size="sm"
                    label-for="perPageSelect"
                    class="mb-0"
                >
                    <b-form-select
                        v-model="perPage"
                        id="perPageSelect"
                        size="sm"
                        :options="pageOptions"
                    ></b-form-select>
                </b-form-group>
            </b-col>
        </b-row>
        <!-- end :: filter and items per page -->

        <!-- begin :: table -->
        <b-table
            striped
            hover
            bordered
            :fields="fields"
            small
            :items="items"
            :busy="isBusy"
            :current-page="currentPage"
            :per-page="perPage"
            :filter="filter"
            show-empty
        >
            <!-- begin :: spinner if busy -->
            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
            <!-- end :: spinner if busy -->
            <!-- begin :: actions column -->
            <template v-slot:cell(actions)="row">
                <div>
                    <b-button-group>
                        <b-button
                            variant="outline-info"
                            size="sm"
                            @click="details(row.item)"
                            v-if="showDetailsAction"
                        >
                            <b-icon
                                icon="info-circle-fill"
                                variant="info"
                            ></b-icon>
                            {{ $t("GENERAL.DETAILS") }}
                        </b-button>
                        <b-button
                            variant="outline-warning"
                            size="sm"
                            v-if="showEditAction"
                            @click="updateItem(row.item)"
                        >
                            <b-icon
                                icon="pencil-square"
                                variant="warning"
                            ></b-icon>
                            {{ $t("GENERAL.UPDATE") }}
                        </b-button>
                        <b-button
                            @click="openDeleteModal(row.item)"
                            variant="outline-danger"
                            size="sm"
                            v-if="showDeleteAction"
                        >
                            <b-icon icon="trash" variant="danger"></b-icon>
                            {{ $t("GENERAL.DELETE") }}
                        </b-button>
                    </b-button-group>
                </div>
            </template>
            <!-- end :: actions column -->
        </b-table>
        <!-- end :: table -->

        <!-- begin :: pagination -->
        <b-row>
            <b-col sm="7" md="6" class="my-1">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    align="fill"
                    size="sm"
                    class="my-0"
                ></b-pagination>
            </b-col>
        </b-row>
        <!-- end :: pagination -->

        <!-- begin :: delete modal -->
        <b-modal
            id="DeleteModal"
            hide-footer
            title="Uyarı!"
            ok-only
            @hide="resetDeleteModal"
        >
            <div>Kayıt kalıcı olarak silinecek!</div>
            <b-row>
                <b-col sm="6" md="6">
                    <b-button
                        class="mt-3"
                        variant="danger"
                        block
                        @click="deleteItem(deleteModal.id)"
                        >{{ $t("GENERAL.DELETE") }}</b-button
                    >
                </b-col>
                <b-col sm="6" md="6">
                    <b-button
                        class="mt-3"
                        block
                        @click="$bvModal.hide('DeleteModal')"
                        >{{ $t("GENERAL.CANCEL") }}</b-button
                    >
                </b-col>
            </b-row>
        </b-modal>
        <!-- end :: delete modal -->
    </div>
</template>

<script>
import XLSX from "xlsx";
export default {
    name: "BootstrapDataTable",
    props: {
        fields: Array,
        items: Array,
        isBusy: { type: Boolean, default: false },
        showDeleteAction: { type: Boolean, default: true },
        deleteAction: { type: String, default: "" },
        title: { type: String, default: "data.xlsx" },
        showEditAction: { type: Boolean, default: true },
        editRouteName: { type: String, default: "" },
        showDetailsAction: { type: Boolean, default: true },
        detailsRouteName: { type: String, default: "" }
    },
    data() {
        return {
            filter: "",
            totalRows: 1,
            currentPage: 1,
            perPage: 10,
            pageOptions: [10, 15, 100, 250, 500],
            deleteModal: { id: null }
        };
    },
    mounted() {
        this.totalRows = this.items.length;
    },
    updated: function() {
        this.totalRows = this.items.length;
    },
    methods: {
        openDeleteModal(item) {
            this.deleteModal.id = item.id;
            this.$bvModal.show("DeleteModal");
        },
        resetDeleteModal() {
            this.deleteModal.id = null;
        },
        async deleteItem(id) {
            await this.$store.dispatch(this.deleteAction, id).then(() => {
                this.$bvModal.hide("DeleteModal");
                this.resetDeleteModal();
            });
        },
        updateItem(item) {
            this.$router.push({
                name: this.editRouteName,
                params: { id: item.id }
            });
        },
        details(item) {
            this.$router.push({
                name: this.detailsRouteName,
                params: { id: item.id }
            });
        },
        downloadXSLX: function() {
            const data = XLSX.utils.json_to_sheet(this.items);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, data, "data");
            XLSX.writeFile(wb, this.title);
        }
    }
};
</script>
