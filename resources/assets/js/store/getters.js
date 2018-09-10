export default {

    all_user_data(state) {
        return state.userData
    },

    lang(state) {
        return state.lang
    },
    getAuth(state) {
        return state.auth;
    },

    getGroupBySlug: (state) => (slug) => {
        let vals = Object.values(state.userData);
        if (!vals) {
            return null;
        }
        return Object.values(state.userData).find(group => group.slug === slug);
    },
    getSubGroupBySlug: (state, getters) => (slug) => {
        if (getters.getGroupBySlug(slug)) {
            return getters.getGroupBySlug(slug).subgroup;
        }
    },
    saveBtn(state) {
        return state.saveBtn;
    },
    currentState(state) {
        return state.currentState;
    },
    getAcceptedCategories(state) {
        if (!!state.acceptedCategories) {
            return state.acceptedCategories;
        }
    },
    getCategories(state) {
        return state.categories;
    },
    routes(state) {
        return state.routes;
    },

    getOrganizationData(state) {
       return state.routes.org;

    },

    getSocialService(state) {
        return  state.routes.social_service;


    },
    getWorkers(state) {
        return state.routes.workers;
    },
    getRoles(state) {
        return state.roles;
    },
    getNeedyUsers(state) {

        return state.needyUsers;
    },

    getStatementsById: (state) => (id) => {

        let vals = Object.values(state.userStatements);

        if (!vals) {
            return null;
        }

        return Object.values(state.userStatements).find(user => user.id === id);
    },
    getStatements: (state, getters) => (id) => {

        if (getters.getStatementsById(id)) {
            return getters.getStatementsById(id);
        }
    },
    getAuth(state) {
        return state.auth
    },
    getSettings(state) {
        return state.settings;
    },
    statements(state) {
        return state.statements;
    },
    pagination(state) {
        return state.pagination;
    },
    getNeedyPages(state) {
        return state.needy_pages;
    },
    getStatementsList(state) {
        return state.statementsList;
    },
    getStatementsPages(state) {
        return state.statements_pages;
    },
    getStatementsAcceptedList(state) {
        return state.statementAccList;
    },
    getStatementsAccceptedPages(state) {
        return state.statementAccPages;
    },
    getStatementsClosedList(state) {
        return state.statementClosedList;
    },
    getStatementsClosedPages(state) {
        return state.statementClosedPages;
    },
    getOrganizationDocuments(state) {
        if (!!state.routes.organization_documents) {
            return state.routes.organization_documents.content;
        }
    },
    getOrganizationHistory(state){
        return state.historyList;
    },
    getHistoryPages(state){
        return state.historyPages;
    },
    getStatementHistory(state){
        return state.historyStatementList;
    },
    getStatementHistoryPages(state){
        return state.historyStatementPages;
    },
    getVolunteers(state){
        return state.routes.volunteers;
    },
    getLocale(state){
        return state.locale;
    },
    getEvent(state){
        return state.event;
    },
    getLoading: (state) => (name) => {
        if(!!state.loadData[name]){
            return state.loadData[name];
        }else{
            return false;
        }
    },
    getAllCategories(state){
        if(!Object.keys(state.allCategories).length) {
            return false;
        } else {
            return state.allCategories;
        }
    }
}



