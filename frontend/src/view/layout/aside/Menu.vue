// eslint-disable-next-line
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
                    <i class="menu-icon flaticon2-architecture-and-city"></i>
                    <span class="menu-text">{{ $t("MENU.DASHBOARD") }}</span>
                </a>
            </li>
        </router-link>

        <li class="menu-section">
            <h4 class="menu-text">{{ $t("MENU.OPERATINOS") }}</h4>
            <i class="menu-icon flaticon-more-v2"></i>
        </li>
        <li
            aria-haspopup="true"
            data-menu-toggle="hover"
            class="menu-item menu-item-submenu"
            v-bind:class="{
                'menu-item-open': hasActiveChildren('/vue-bootstrap/button')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-child">
                    <span></span>
                </i>
                <span class="menu-text">Öğrenci Taşımacılığı</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
                <span class="menu-arrow"></span>
                <ul class="menu-subnav">
                    <li aria-haspopup="true" class="menu-item menu-item-parent">
                        <span class="menu-link">
                            <span class="menu-text"></span>
                        </span>
                    </li>

                    <router-link
                        to="/ogrenciler"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Öğrenciler</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/okul"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Okullar</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/arac-okul/ekle"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                    >Okul İle Servis İlişkilendirme</span
                                >
                            </a>
                        </li>
                    </router-link>

                    <router-link
                        to="/veliler"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Veliler</span>
                            </a>
                        </li>
                    </router-link>

                    <router-link
                        to="/haritalar"
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
                                <i class="menu-icon fas fa-map-marked-alt"></i>
                                <span class="menu-text">
                                    {{ $t("STUDENT.LOCATIONS") }}
                                </span>
                            </a>
                        </li>
                    </router-link>
                </ul>
            </div>
        </li>
        <li
            aria-haspopup="true"
            data-menu-toggle="hover"
            class="menu-item menu-item-submenu"
            v-bind:class="{
                'menu-item-open': hasActiveChildren('/vue-bootstrap/button')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-school">
                    <span></span>
                </i>
                <span class="menu-text">Personel Taşımacılığı</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
                <span class="menu-arrow"></span>
                <ul class="menu-subnav">
                    <li aria-haspopup="true" class="menu-item menu-item-parent">
                        <span class="menu-link">
                            <span class="menu-text"></span>
                        </span>
                    </li>

                    <router-link
                        to="/teklifler/ekle"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Teklif Ver</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/teklifler"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Teklifler</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/tasima-personeller"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Personeller</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/#"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Güzergahlar</span>
                            </a>
                        </li>
                    </router-link>
                </ul>
            </div>
        </li>
        <li
            aria-haspopup="true"
            data-menu-toggle="hover"
            class="menu-item menu-item-submenu"
            v-bind:class="{
                'menu-item-open': hasActiveChildren('/vue-bootstrap/button')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-cash-register">
                    <span></span>
                </i>
                <span class="menu-text">Muhasebe</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
                <span class="menu-arrow"></span>
                <ul class="menu-subnav">
                    <li aria-haspopup="true" class="menu-item menu-item-parent">
                        <span class="menu-link">
                            <span class="menu-text"></span>
                        </span>
                    </li>

                    <router-link
                        to="/cari-grup"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Cari Grubu</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/cariler"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Cari</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/hesaplar"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Hesap</span>
                            </a>
                        </li>
                    </router-link>
                </ul>
            </div>
        </li>
        <li
            aria-haspopup="true"
            data-menu-toggle="hover"
            class="menu-item menu-item-submenu"
            v-bind:class="{
                'menu-item-open': hasActiveChildren('/vue-bootstrap/button')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-people-carry">
                    <span></span>
                </i>
                <span class="menu-text">Personel</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
                <span class="menu-arrow"></span>
                <ul class="menu-subnav">
                    <li aria-haspopup="true" class="menu-item menu-item-parent">
                        <span class="menu-link">
                            <span class="menu-text"></span>
                        </span>
                    </li>

                    <router-link
                        to="/personel-grup"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        to="/personeller/"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                </ul>
            </div>
        </li>

        <router-link
            to="/araclar/"
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
                    <i class="menu-icon fas fa-car">
                        <span></span>
                    </i>
                    <span class="menu-text">{{ $t("CARS.CAR") }}</span>
                </a>
            </li>
        </router-link>

        <router-link
            to="/soforler/"
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
                    <i class="menu-icon fas fa-user-alt">
                        <span></span>
                    </i>
                    <span class="menu-text">Şoför</span>
                </a>
            </li>
        </router-link>
        <router-link
            to="/hostesler/"
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
                    <i class="menu-icon fas fa-female">
                        <span></span>
                    </i>
                    <span class="menu-text">Hostes</span>
                </a>
            </li>
        </router-link>
        <li
            aria-haspopup="true"
            data-menu-toggle="hover"
            class="menu-item menu-item-submenu"
            v-bind:class="{
                'menu-item-open': hasActiveChildren('/vue-bootstrap/button')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-sitemap">
                    <span></span>
                </i>
                <span class="menu-text">Raporlar</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
                <span class="menu-arrow"></span>
                <ul class="menu-subnav">
                    <li aria-haspopup="true" class="menu-item menu-item-parent">
                        <span class="menu-link">
                            <span class="menu-text"></span>
                        </span>
                    </li>

                    <router-link
                        to="/raporlar/okul-ciro"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
            data-menu-toggle="hover"
            class="menu-item menu-item-submenu"
            v-bind:class="{
                'menu-item-open': hasActiveChildren('/vue-bootstrap/button')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon fas fa-plus">
                    <span></span>
                </i>
                <span class="menu-text">Bilgi Girişi</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
                <span class="menu-arrow"></span>
                <ul class="menu-subnav">
                    <li aria-haspopup="true" class="menu-item menu-item-parent">
                        <span class="menu-link">
                            <span class="menu-text"></span>
                        </span>
                    </li>
                    <router-link
                        to="/personel-grup"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Araç</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/ogrenciler/ekle"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
        <li class="menu-section">
            <h4 class="menu-text">Ayarlar</h4>
            <i class="menu-icon flaticon-more-v2"></i>
        </li>

        <li
            aria-haspopup="true"
            data-menu-toggle="hover"
            class="menu-item menu-item-submenu"
            v-bind:class="{
                'menu-item-open': hasActiveChildren('/error/error')
            }"
        >
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon flaticon2-list-2"></i>
                <span class="menu-text">Ayarlar</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu">
                <span class="menu-arrow"></span>
                <ul class="menu-subnav">
                    <li aria-haspopup="true" class="menu-item menu-item-parent">
                        <span class="menu-link">
                            <span class="menu-text">Error Pages</span>
                        </span>
                    </li>

                    <router-link
                        to="/vergi-grup"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">Vergi Grubu</span>
                            </a>
                        </li>
                    </router-link>
                    <router-link
                        to="/fiyatlandirma-turleri"
                        v-slot="{
                            href,
                            navigate,
                            isActive,
                            isExactActive
                        }"
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
                                <span class="menu-text">{{
                                    $t("FIYATLANDIRMA.FIYATLANDIRMALAR")
                                }}</span>
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
