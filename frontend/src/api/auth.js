import apiClient from './client';

export const login = (password) => apiClient.post('/auth/login', { password });
export const logout = () => apiClient.post('/auth/logout');
