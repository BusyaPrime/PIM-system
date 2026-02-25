module.exports = {
    omnipim: {
        input: '../../../backend/openapi.json',
        output: {
            mode: 'tags-split',
            target: 'src/generated/api.ts',
            schemas: 'src/generated/model',
            client: 'react-query',
            mock: false,
            baseUrl: '/api',
            override: {
                mutator: {
                    path: 'src/custom-instance.ts',
                    name: 'customInstance'
                }
            }
        }
    }
};
