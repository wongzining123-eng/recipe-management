import React, { useState, useEffect } from 'react';
import axios from 'axios';

function Profile() {
    const [profile, setProfile] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [success, setSuccess] = useState(null);
    const [editing, setEditing] = useState(false);
    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const [deletePassword, setDeletePassword] = useState('');

    const [formData, setFormData] = useState({
        name: '',
        email: ''
    });

    const [passwordData, setPasswordData] = useState({
        current_password: '',
        new_password: '',
        new_password_confirmation: ''
    });

    const API = '/api/profile';

    // GET PROFILE
    const fetchProfile = async () => {
        try {
            setLoading(true);

            const res = await axios.get(API, {
                withCredentials: true
            });

            setProfile(res.data);

            setFormData({
                name: res.data.name,
                email: res.data.email
            });

        } catch (err) {
            console.error(err);
            setError(
                err.response?.status === 401
                    ? 'Please login to continue'
                    : 'Failed to load profile'
            );
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchProfile();
    }, []);

    // UPDATE PROFILE
    const updateProfile = async (e) => {
        e.preventDefault();
        setError(null);
        setSuccess(null);

        try {
            const res = await axios.put(API, formData, {
                withCredentials: true
            });

            if (res.data.success) {
                setSuccess(res.data.message);
                setProfile(res.data.user);
                setEditing(false);
            }
        } catch (err) {
            console.error(err);
            setError(err.response?.data?.message || 'Update failed');
        }
    };

    // UPDATE PASSWORD
    const updatePassword = async (e) => {
        e.preventDefault();
        setError(null);
        setSuccess(null);

        try {
            const res = await axios.put(`${API}/password`, passwordData, {
                withCredentials: true
            });

            if (res.data.success) {
                setSuccess(res.data.message);
                setPasswordData({
                    current_password: '',
                    new_password: '',
                    new_password_confirmation: ''
                });
            }
        } catch (err) {
            console.error(err);
            setError(err.response?.data?.message || 'Password update failed');
        }
    };

    // DELETE ACCOUNT
    const deleteAccount = async () => {
        setError(null);
        setSuccess(null);

        try {
            const res = await axios.delete(API, {
                data: { password: deletePassword },
                withCredentials: true
            });

            if (res.data.success) {
                window.location.href = '/';
            }
        } catch (err) {
            console.error(err);
            setError(err.response?.data?.message || 'Delete failed');
            setShowDeleteModal(false);
            setDeletePassword('');
        }
    };

    const goToDashboard = () => {
        window.location.href = '/admin/dashboard';
    };

    if (loading) {
        return (
            <div className="container mt-4 text-center">
                <div className="spinner-border text-primary" />
                <p>Loading profile...</p>
            </div>
        );
    }

    return (
        <div className="container mt-4">

            <div className="d-flex justify-content-between mb-4">
                <h1>My Profile</h1>
                <button className="btn btn-secondary" onClick={goToDashboard}>
                    ← Back
                </button>
            </div>

            {error && <div className="alert alert-danger">{error}</div>}
            {success && <div className="alert alert-success">{success}</div>}

            {/* PROFILE INFO */}
            <div className="card mb-4">
                <div className="card-header d-flex justify-content-between">
                    <h5>Profile Information</h5>
                    {!editing && (
                        <button className="btn btn-primary btn-sm" onClick={() => setEditing(true)}>
                            Edit
                        </button>
                    )}
                </div>

                <div className="card-body">
                    {!editing ? (
                        <>
                            <p><b>Name:</b> {profile?.name}</p>
                            <p><b>Email:</b> {profile?.email}</p>
                            <p>
                                <b>Role:</b>{" "}
                                {profile?.is_admin ? (
                                    <span className="badge bg-danger">Admin</span>
                                ) : (
                                    <span className="badge bg-secondary">User</span>
                                )}
                            </p>
                        </>
                    ) : (
                        <form onSubmit={updateProfile}>
                            <input
                                className="form-control mb-2"
                                value={formData.name}
                                onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                            />

                            <input
                                className="form-control mb-2"
                                value={formData.email}
                                onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                            />

                            <button className="btn btn-success me-2">Save</button>
                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={() => {
                                    setEditing(false);
                                    setFormData({
                                        name: profile.name,
                                        email: profile.email
                                    });
                                }}
                            >
                                Cancel
                            </button>
                        </form>
                    )}
                </div>
            </div>

            {/* PASSWORD */}
            <div className="card mb-4">
                <div className="card-header">
                    <h5>Change Password</h5>
                </div>

                <div className="card-body">
                    <form onSubmit={updatePassword}>
                        <input
                            type="password"
                            className="form-control mb-2"
                            placeholder="Current password"
                            value={passwordData.current_password}
                            onChange={(e) =>
                                setPasswordData({ ...passwordData, current_password: e.target.value })
                            }
                        />

                        <input
                            type="password"
                            className="form-control mb-2"
                            placeholder="New password"
                            value={passwordData.new_password}
                            onChange={(e) =>
                                setPasswordData({ ...passwordData, new_password: e.target.value })
                            }
                        />

                        <input
                            type="password"
                            className="form-control mb-2"
                            placeholder="Confirm password"
                            value={passwordData.new_password_confirmation}
                            onChange={(e) =>
                                setPasswordData({
                                    ...passwordData,
                                    new_password_confirmation: e.target.value
                                })
                            }
                        />

                        <button className="btn btn-warning">Update Password</button>
                    </form>
                </div>
            </div>

            {/* DELETE */}
            <div className="card border-danger">
                <div className="card-header bg-danger text-white">
                    <h5>Danger Zone</h5>
                </div>

                <div className="card-body">
                    <button
                        className="btn btn-danger"
                        onClick={() => setShowDeleteModal(true)}
                    >
                        Delete Account
                    </button>
                </div>
            </div>

            {/* MODAL */}
            {showDeleteModal && (
                <div className="modal d-block" style={{ background: 'rgba(0,0,0,0.5)' }}>
                    <div className="modal-dialog">
                        <div className="modal-content">

                            <div className="modal-header">
                                <h5>Confirm Delete</h5>
                                <button
                                    className="btn-close"
                                    onClick={() => setShowDeleteModal(false)}
                                />
                            </div>

                            <div className="modal-body">
                                <input
                                    type="password"
                                    className="form-control"
                                    placeholder="Enter password"
                                    value={deletePassword}
                                    onChange={(e) => setDeletePassword(e.target.value)}
                                />
                            </div>

                            <div className="modal-footer">
                                <button
                                    className="btn btn-secondary"
                                    onClick={() => setShowDeleteModal(false)}
                                >
                                    Cancel
                                </button>

                                <button
                                    className="btn btn-danger"
                                    onClick={deleteAccount}
                                >
                                    Delete
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            )}

        </div>
    );
}

export default Profile;