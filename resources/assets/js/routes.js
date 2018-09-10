import VueRouter from 'vue-router';

let routes = [
    {
        name:'destitute',
        path: '/user/:slug',
        component: require('./components/user/UserInformationComponent'),

    },
    {
        name:'offers',
        path:'/personal/offers',
        component:require('./components/pages/OffersComponent'),
    },
    {
        name:'social-service',
        path:'/personal/social-service',
        component:require('./components/social-service/SocialServiceComponent'),
    },
    {
        name:'organization',
        path:'/personal/organization',
        component:require('./components/organization/OrganizationComponent'),
    },
    {
        name:'create_worker',
        path:'/personal/create-worker',
        component:require('./components/social-service/CreateWorkerComponent'),
    },
    {
        name:'create-volunteer',
        path:'/personal/create-volunteer',
        component:require('./components/organization/CreateVolunteer'),
    },

    {
        name:'social-service-statements',
        path:'/personal/social-statements',
        component:require('./components/social-service/SocialServiceStatementComponent'),
    },
    {
        name:'statement-create-social',
        path:'/personal/social-statement-create',
        component:require('./components/social-service/StatementCreateSocialServiceComponent'),
    },
    {
        name:'create_needy',
        path:'/personal/create-needy',
        component:require('./components/social-service/CreateNeedyComponent'),
    },
    {
        name:'user-statements',
        path:'/personal/user-statements',
        component:require('./components/user/UserStatementsComponent'),
    },
    {
        name:'statement-detail',
        path:'/personal/statement-detail/:uuid',
        component:require('./components/statements/StatementDetailComponent'),
    },
    {
        name:'social_statements_list',
        path:'/personal/social-statements-list',
        component:require('./components/social-service/SocialStatementsListComponent'),
    },
    {
        name:'no-accepted-statements',
        path:'/personal/no-accepted-statements',
        component:require('./components/organization/NoAcceptedStatementsComponent'),
    },
    {
        name:'social-service-workers',
        path:'/personal/service-workers',
        component:require('./components/social-service/SocialServiceWorkersComponent'),
    },
    {
        name:'organization-volunteers',
        path:'/personal/organization-volunteers',
        component:require('./components/organization/OrganizationVolunteersComponent'),
    },
    {
        name:'organization-documents',
        path:'/personal/organization-documents',
        component:require('./components/organization/OrganizationDocumentsComponent'),
    },
    {
        name:'statement-create-organization',
        path:'/personal/organization-statement-create',
        component:require('./components/organization/OrganizationStatementCreate'),
    },
    {
        name:'sub-statement-detail',
        path:'/personal/sub-statement-detail/:uuid',
        component:require('./components/statements/SubStatementDetailComponent'),
    },
    {
        name:"organization-accepted-statements",
        path:'/personal/accepted-statements',
        component:require('./components/organization/OrganizationAcceptedStatements'),
    },
    {
        name:'organization-closed-statements',
        path:'/personal/closed-statements',
        component:require('./components/organization/OrganizationClosedStatements'),
    },
    {
        name:'revision-history',
        path:'/personal/history',
        component:require('./components/organization/History'),
    },
    {
        name:'history-statement',
        path:'/personal/history-statement/:uuid',
        component:require('./components/statements/HistoryStatement'),
    },
    {
        name:'write-admin',
        path:'/personal/write-admin',
        component:require('./components/user/WriteAdmin'),
    },
    {
        name:'statistics',
        path:'/personal/statistics',
        component:require('./components/organization/Statistics'),
    },
    {
        name:"social-service-statistic",
        path:'/personal/social-statistics',
        component:require('./components/social-service/SocialServiceStatistic'),
    },
    {
        name:'organization-statements',
        path:'/personal/organization-statements',
        component:require('./components/organization/OrganizationStatements'),
    },



];


export default new VueRouter({
    mode: 'history',
    routes
});

