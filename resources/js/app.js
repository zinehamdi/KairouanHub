import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

window.Alpine = Alpine;

/**
 * Service wizard component — used in services/index.blade.php
 * Wizard steps: categories → services → details
 *
 * @param {Array} wizardData  - [{id, slug, name, services: [{id, name, summary, slug}]}]
 * @param {Array} groups      - [{key, name_ar, name_en, emoji, keywords:[]}]
 */
/**
 * Enhanced Service Browser component
 * 3-level navigation: Category Group → Service Category → Provider Service
 * 
 * browserData: [{ key, name, emoji, gradient, categories: [{ id, slug, name, icon, services: [] }] }]
 */
Alpine.data('serviceBrowser', (browserData) => ({
    open: false,
    step: 'groups', // groups | categories | services
    selectedGroup: null,
    selectedCategory: null,
    browserData: browserData,

    init() {
        // Handle deep-linking from Category Cards (slug based)
        const urlParams = new URLSearchParams(window.location.search);
        const catSlug = urlParams.get('category');
        if (catSlug) {
            this.browserData.forEach(group => {
                const cat = group.categories.find(c => c.slug === catSlug);
                if (cat) {
                    this.selectedGroup = group.key;
                    this.selectedCategory = cat.id;
                    this.step = 'services';
                    this.open = true;
                }
            });
        }
    },

    get currentGroup() {
        return this.browserData.find(g => g.key === this.selectedGroup);
    },

    get currentCategory() {
        if (!this.currentGroup) return null;
        return this.currentGroup.categories.find(c => c.id === this.selectedCategory);
    },

    openGroup(key) {
        this.selectedGroup = key;
        this.selectedCategory = null;
        this.step = 'categories';
        this.open = true;
        // Update URL without refresh (clean logic)
        // window.history.pushState({}, '', '?group=' + key);
    },

    openCategory(catId) {
        this.selectedCategory = catId;
        this.step = 'services';
        this.open = true;
    },

    goBack() {
        if (this.step === 'services') {
            this.step = 'categories';
            this.selectedCategory = null;
        } else if (this.step === 'categories') {
            this.step = 'groups';
            this.selectedGroup = null;
        }
    },

    closeModal() {
        this.open = false;
        // Reset state after transition completes
        setTimeout(() => {
            if (!this.open) {
                this.step = 'groups';
                this.selectedGroup = null;
                this.selectedCategory = null;
            }
        }, 300);
    },

    resetAndOpen() {
        this.selectedGroup = null;
        this.selectedCategory = null;
        this.step = 'groups';
        this.open = true;
    }
}));

Alpine.start();
