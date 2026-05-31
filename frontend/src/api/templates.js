import apiClient from './client';

export const getTemplates = () => apiClient.get('/templates');
export const getTemplate = (id) => apiClient.get(`/templates/${id}`);
