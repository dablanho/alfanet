<template>
    <ul class="menu-nav">
        <router-link
            to="/dashboard"
            v-slot="{ href, navigate, isActive, isExactActive }"
        >
            <li
                aria-haspopup="true"
                data-menu-toggle="hover"
                class="menu-item"
                :class="[
                    isActive && 'menu-item-active',
                    isExactActive && 'menu-item-active'
                ]"
            >
                <a :href="href" class="menu-link" @click="navigate">
                    <span class="menu-text">{{ $t("MENU.DASHBOARD") }}</span>
                </a>
            </li>
        </router-link>
        <li
            aria-haspopup="true"
            data-menu-toggle="click"
            class="menu-item menu-item-submenu menu-item-open-dropdown"
            v-bind:class="{
                'menu-item-active': hasActiveChildren('/error/error')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <span class="menu-text">Raporlar</span>
            </a>
            <div class="menu-submenu menu-submenu-classic">
                <ul class="menu-subnav">
                    <router-link
                        to="/raporlar/okul-ciro"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Okul Ciroları</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/raporlar/bu-ay-kalan"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text"
                                    >Bu Ay Borcu Bulunan Öğrenciler</span
                                >
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/raporlar/okul-toplam-kalan"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text"
                                    >Okul Bazlı Aylık Toplam/Ödenen
                                    Listesi</span
                                >
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/raporlar/tolu-ogrenciler-manuel"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text"
                                    >Toplu Öğrenciler(Manuel)</span
                                >
                            </a>
                        </li>
                    </router-link>
                </ul>
            </div>
        </li>
        <li
            aria-haspopup="true"
            data-menu-toggle="click"
            class="menu-item menu-item-submenu menu-item-open-dropdown"
            v-bind:class="{
                'menu-item-active': hasActiveChildren('/error/error')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <span class="menu-text">Bilgi Girişi</span>
            </a>
            <div class="menu-submenu menu-submenu-classic">
                <ul class="menu-subnav">
                    <router-link
                        to="/personel-grup"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Personel Grubu</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/personeller/ekle"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Personel</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/veliler/ekle"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Veli</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/araclar/ekle"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">
                                    {{ $t("CARS.CAR") }}
                                </span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/ogrenciler/ekle"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Öğrenci</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/okul/ekle"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Okul</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/soforler/ekle"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Şoför</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/hostesler/ekle"
                        v-slot="{ href, navigate, isActive, isExactActive }"
                    >
                        <li
                            aria-haspopup="true"
                            data-menu-toggle="hover"
                            class="menu-item"
                            :class="[
                                isActive && 'menu-item-active',
                                isExactActive && 'menu-item-active'
                            ]"
                        >
                            <a :href="href" class="menu-link" @click="navigate">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Hostes</span>
                            </a>
                        </li>
                    </router-link>
                </ul>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    name: "KTMenu",
    methods: {
        hasActiveChildren(match) {
            return this.$route["path"].indexOf(match) !== -1;
        }
    }
};
</script>
