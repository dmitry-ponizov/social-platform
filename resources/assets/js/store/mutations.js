export default {

    add_user_data(state, payload) {
        Vue.set(state, 'userData', payload);
    },

    update_user_data(state, payload) {

        Vue.set(state.userData[payload.group_id]['subgroup'][payload.sub_id]['rules'], payload.rule_id, payload.value[payload.rule_id]);
    },
    change_save_btn(state, payload) {
        Vue.set(state, 'saveBtn', payload);
    },

    update_all_user_data(state, payload) {

        Vue.set(state.userData, payload.group_id, payload.value[payload.group_id]);
    },
    add_lang(state, payload) {
        Vue.set(state, 'lang', payload);
    },
    add_user(state, payload) {
        Vue.set(state, 'auth', payload);
    },
    add_avatar(state, payload) {
        Vue.set(state.auth, 'avatar', payload);
    },
    add_accepted_cat(state, payload) {
        Vue.set(state, 'acceptedCategories', payload);
    },
    add_new_accepted_cat(state, payload) {
        Vue.set(state.acceptedCategories, payload.id, payload);
    },
    delete_category(state, payload) {
        Vue.delete(state.acceptedCategories.categories, payload)
    },
    add_routes(state, payload) {
        Vue.set(state, 'routes', payload);
    },
    updateSocialServiceField(state, payload) {
        Vue.set(state.routes.social_service.content, payload.field, payload.value);
    },
    updateAllSocialServiceInfo(state, payload) {
        Vue.set(state.routes.social_service, 'content', payload);
    },

    add_roles(state, payload) {
        Vue.set(state, 'roles', payload);
    },
    add_worker(state, payload) {
        Vue.set(state.routes.workers, payload.id, payload);
    },
    add_needy(state, payload) {
        Vue.set(state.needyUsers, payload.current_page, payload.data);
    },
    update_needy(state, payload) {
        Vue.set(state.needyUsers, payload.id, payload);
    },
    add_statements(state, payload) {
        Vue.set(state.userStatements, payload.id, payload);
    },

    updateStatementField(state, payload) {
        Vue.set(state.userStatements[payload.user_id]['statements'][payload.id], payload.field, payload.value);
        Vue.set(state.userStatements[payload.user_id]['statements'][payload.id], 'updated_date', payload.updated_date);
    },

    updateChildrenStatementField(state, payload) {
        Vue.set(state.userStatements[payload.user_id]['statements'][payload.parent_id]['children'][payload.id], payload.field, payload.value);
        Vue.set(state.userStatements[payload.user_id]['statements'][payload.parent_id]['children'][payload.id], 'updated_date', payload.updated_date);
    },

    add_statement_image(state, payload) {
        if (!state.userStatements[payload.user_id]['statements'][payload.id]['images']) {
            Vue.set(state.userStatements[payload.user_id]['statements'][payload.id], 'images', {});
        }
        Vue.set(state.userStatements[payload.user_id]['statements'][payload.id]['images'], payload.image_id, payload.name);
    },
    add_children_statement_image(state, payload) {
        if (!state.userStatements[payload.user_id]['statements'][payload.parent_id]['children'][payload.id]['images']) {
            Vue.set(state.userStatements[payload.user_id]['statements'][payload.parent_id]['children'][payload.id], 'images', {});
        }
        Vue.set(state.userStatements[payload.user_id]['statements'][payload.parent_id]['children'][payload.id]['images'], payload.image_id, payload.name);
    },
    updateOrganizationField(state, payload) {
        Vue.set(state.routes.org.content, payload.field, payload.value);
    },
    updateAllOrganizationInfo(state, payload) {
        Vue.set(state.routes.org, 'content', payload);
    },
    add_settings(state, payload) {
        Vue.set(state, 'settings', payload);
    },
    addStatements(state, payload) {
        Vue.set(state, 'statements', payload);
    },
    addPagination(state, payload) {
        Vue.set(state, 'pagination', payload);
    },
    add_needy_pages(state, payload) {
        Vue.set(state.needy_pages, payload.current_page, payload);
    },
    add_statements_list(state, payload) {
        Vue.set(state.statementsList, payload.current_page, payload.data);
    },
    add_statement_accepted_list(state, payload) {
        Vue.set(state.statementAccList, payload.current_page, payload.data);
    },
    add_statement_accepted_pages(state, payload) {
        Vue.set(state.statementAccPages, payload.current_page, payload);
    },
    add_statement_closed_list(state, payload) {
        Vue.set(state.statementClosedList, payload.current_page, payload.data);
    },
    add_statement_closed_pages(state, payload) {
        Vue.set(state.statementClosedPages, payload.current_page, payload);
    },
    add_statements_pages(state, payload) {
        Vue.set(state.statements_pages, payload.current_page, payload);
    },
    add_organization_documents(state, payload) {
        Vue.set(state.routes.organization_documents.content, Object.keys(payload), payload[Object.keys(payload)]);
    },
    delete_organization_document(state, payload) {

        Vue.delete(state.routes.organization_documents.content[payload.name], payload.id);
    },
    update_organization_documents(state, payload) {
        Vue.set(state.routes.organization_documents.content[payload.name], payload.id, payload);
    },
    add_categories(state, payload) {
        Vue.set(state, 'categories', payload);
    },
    delete_acc_category(state, payload) {
        Vue.delete(state.acceptedCategories, payload);
    },
    add_category(state, payload) {
        Vue.set(state.categories, payload.id, payload);
    },
    add_children_statement(state, payload) {
        if (!state.userStatements[payload.user_id]['statements'][payload.parent_id]['children']) {
            Vue.set(state.userStatements[payload.user_id]['statements'][payload.parent_id], 'children', {});
        }
        Vue.set(state.userStatements[payload.user_id]['statements'][payload.parent_id]['children'], payload.id, payload);
    },
    add_history_list(state, payload) {
        Vue.set(state.historyList, payload.current_page, payload.data);
    },
    add_history_pages(state, payload) {
        Vue.set(state.historyPages, payload.current_page, payload);
    },
    add_history_statement_list(state, payload) {
        Vue.set(state.historyStatementList, payload.current_page, payload.data);
    },
    add_statement_history_pages(state, payload) {
        Vue.set(state.historyStatementPages, payload.current_page, payload);
    },
    add_volunteer(state, payload) {
        state.routes.volunteers.content.push(payload);
    },
    add_locale(state, payload) {
        state.locale = payload;
    },
    set_event(state, payload) {
        Vue.set(state, 'event', payload)
    },
    changeOrganizationLogo(state, payload){
        state.routes.org.content.logo = payload;
    },
    changeSocialServiceLogo(state, payload){
        state.routes.social_service.content.logo = payload;
    },
    setAllCategories(state, payload) {
        state.allCategories = payload;
    }


}