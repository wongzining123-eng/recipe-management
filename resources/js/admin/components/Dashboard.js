import React, { useState, useEffect } from 'react';
import axios from 'axios';

function Dashboard() {
    const [data, setData] = useState(null);
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(true);
    const [hoveredStat, setHoveredStat] = useState(null);
    const [hoveredShortcut, setHoveredShortcut] = useState(null);

    useEffect(() => {
        let isMounted = true;

        axios.get('/admin/api/dashboard', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json',
            },
            withCredentials: true
        })
        .then(res => {
            if (isMounted) {
                setData(res.data);
                setLoading(false);
            }
        })
        .catch(err => {
            let msg = 'Something went wrong';
            if (err.response?.status === 401) msg = 'Please login to continue';
            if (err.response?.status === 403) msg = 'You do not have admin access';
            if (isMounted) {
                setError(msg);
                setLoading(false);
            }
        });

        return () => (isMounted = false);
    }, []);

    if (loading) {
        return (
            <div style={{
                minHeight: '100vh',
                background: '#f8fafc',
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                justifyContent: 'center',
                gap: 16
            }}>
                <style>{`
                    @keyframes spin { to { transform: rotate(360deg); } }
                    @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }
                `}</style>
                <div style={{
                    width: 48,
                    height: 48,
                    border: '4px solid #e2e8f0',
                    borderTop: '4px solid #6366f1',
                    borderRadius: '50%',
                    animation: 'spin 0.8s linear infinite'
                }} />
                <p style={{ color: '#94a3b8', fontSize: 14, margin: 0 }}>Loading dashboard...</p>
            </div>
        );
    }

    if (error) {
        return (
            <div style={{
                minHeight: '100vh',
                background: '#f8fafc',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center'
            }}>
                <div style={{
                    background: '#fff',
                    borderRadius: 20,
                    padding: '48px 56px',
                    boxShadow: '0 4px 32px rgba(0,0,0,0.08)',
                    textAlign: 'center',
                    maxWidth: 380
                }}>
                    <div style={{ fontSize: 52, marginBottom: 16 }}>🔒</div>
                    <h3 style={{ color: '#1e293b', marginBottom: 8, fontSize: 20 }}>Access Denied</h3>
                    <p style={{ color: '#94a3b8', fontSize: 14, marginBottom: 28 }}>{error}</p>
                    <button
                        onClick={() => window.location.reload()}
                        style={{
                            background: '#6366f1',
                            color: '#fff',
                            border: 'none',
                            borderRadius: 10,
                            padding: '11px 32px',
                            fontSize: 14,
                            fontWeight: 600,
                            cursor: 'pointer',
                            letterSpacing: 0.3
                        }}
                    >
                        Retry
                    </button>
                </div>
            </div>
        );
    }

    const stats = [
        {
            title: 'Total Recipes',
            value: data?.totalRecipes || 0,
            emoji: '🍽️',
            accent: '#6366f1',
            light: '#eef2ff'
        },
        {
            title: 'Total Users',
            value: data?.totalUsers || 0,
            emoji: '👤',
            accent: '#0ea5e9',
            light: '#e0f2fe'
        },
        {
            title: 'Total Categories',
            value: data?.totalCategories || 0,
            emoji: '🏷️',
            accent: '#10b981',
            light: '#d1fae5'
        }
    ];

    const shortcuts = [
        {
            title: 'Manage Recipes',
            desc: 'Add, edit or remove recipes',
            emoji: '🍽️',
            href: '/recipes',  
            accent: '#6366f1',
            light: '#eef2ff',
            border: '#c7d2fe'
        },
        {
            title: 'Manage Users',
            desc: 'Control roles and accounts',
            emoji: '👤',
            href: '/admin/users',  
            accent: '#0ea5e9',
            light: '#e0f2fe',
            border: '#bae6fd'
        },
        {
            title: 'Manage Categories',
            desc: 'Organise recipe categories',
            emoji: '🏷️',
            href: '/categories',  
            accent: '#10b981',
            light: '#d1fae5',
            border: '#a7f3d0'
        }
    ];

    return (
        <div style={{ minHeight: '100vh', background: '#f8fafc' }}>
            <style>{`
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(12px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
            `}</style>

            <div style={{ maxWidth: 1080, margin: '0 auto', padding: '40px 24px', animation: 'fadeIn 0.4s ease' }}>

                {/* ── HEADER ── */}
                <div style={{
                    background: 'linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%)',
                    borderRadius: 22,
                    padding: '36px 40px',
                    marginBottom: 32,
                    boxShadow: '0 8px 40px rgba(99,102,241,0.28)',
                    position: 'relative',
                    overflow: 'hidden'
                }}>
                    {/* decorative circles */}
                    <div style={{
                        position: 'absolute', top: -30, right: -30,
                        width: 160, height: 160, borderRadius: '50%',
                        background: 'rgba(255,255,255,0.07)'
                    }} />
                    <div style={{
                        position: 'absolute', bottom: -50, right: 80,
                        width: 120, height: 120, borderRadius: '50%',
                        background: 'rgba(255,255,255,0.05)'
                    }} />

                    <div style={{
                        fontSize: 11,
                        fontWeight: 700,
                        letterSpacing: 3,
                        textTransform: 'uppercase',
                        color: 'rgba(255,255,255,0.6)',
                        marginBottom: 10
                    }}>
                        Admin Panel
                    </div>
                    <h1 style={{
                        margin: 0,
                        fontSize: 30,
                        fontWeight: 800,
                        color: '#fff',
                        letterSpacing: -0.5
                    }}>
                        Dashboard
                    </h1>
                    <p style={{ margin: '8px 0 0', color: 'rgba(255,255,255,0.7)', fontSize: 14 }}>
                        Welcome back, Admin 👋
                    </p>
                </div>

                {/* ── STAT CARDS ── */}
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3,1fr)', gap: 18, marginBottom: 32 }}>
                    {stats.map((s, i) => (
                        <div
                            key={i}
                            onMouseEnter={() => setHoveredStat(i)}
                            onMouseLeave={() => setHoveredStat(null)}
                            style={{
                                background: '#fff',
                                borderRadius: 18,
                                padding: '26px 28px',
                                borderTop: `4px solid ${s.accent}`,
                                boxShadow: hoveredStat === i
                                    ? '0 16px 48px rgba(0,0,0,0.11)'
                                    : '0 2px 16px rgba(0,0,0,0.05)',
                                transform: hoveredStat === i ? 'translateY(-5px)' : 'none',
                                transition: 'all 0.2s ease',
                                cursor: 'default'
                            }}
                        >
                            <div style={{
                                width: 46,
                                height: 46,
                                borderRadius: 13,
                                background: s.light,
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                fontSize: 22,
                                marginBottom: 18
                            }}>
                                {s.emoji}
                            </div>
                            <div style={{ fontSize: 12, color: '#94a3b8', fontWeight: 700, textTransform: 'uppercase', letterSpacing: 1.2 }}>
                                {s.title}
                            </div>
                            <div style={{ fontSize: 38, fontWeight: 800, color: '#1e293b', marginTop: 4, lineHeight: 1 }}>
                                {s.value}
                            </div>
                        </div>
                    ))}
                </div>

                {/* ── QUICK ACTIONS ── */}
                {shortcuts.map((s, i) => (
                    <a
                        key={i}
                        href={s.href}
                        onMouseEnter={() => setHoveredShortcut(i)}
                        onMouseLeave={() => setHoveredShortcut(null)}
                        style={{
                            display: 'flex',
                            alignItems: 'center',
                            gap: 14,
                            padding: '16px 18px',
                            borderRadius: 14,
                            border: `2px solid ${hoveredShortcut === i ? s.border : '#f1f5f9'}`,
                            background: hoveredShortcut === i ? s.light : '#fafafa',
                            textDecoration: 'none',
                            transition: 'all 0.2s ease',
                            transform: hoveredShortcut === i ? 'translateY(-2px)' : 'none',
                            boxShadow: hoveredShortcut === i ? '0 6px 24px rgba(0,0,0,0.07)' : 'none'
                        }}
                    >
                        <div style={{
                            width: 42,
                            height: 42,
                            borderRadius: 11,
                            background: s.light,
                            border: `1.5px solid ${s.border}`,
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            fontSize: 20,
                            flexShrink: 0
                        }}>
                            {s.emoji}
                        </div>

                        <div style={{ minWidth: 0 }}>
                            <div style={{ fontSize: 13, fontWeight: 700, color: s.accent }}>
                                {s.title}
                            </div>
                            <div style={{ fontSize: 11, color: '#94a3b8', marginTop: 2 }}>
                                {s.desc}
                            </div>
                        </div>

                        <div style={{ marginLeft: 'auto', color: '#cbd5e1', fontSize: 20 }}>
                            ›
                        </div>
                    </a>
                ))}
                {/* ── RECENT SECTION ── */}
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 20 }}>

                    {/* Recent Recipes */}
                    <div style={{
                        background: '#fff',
                        borderRadius: 20,
                        padding: '26px 30px',
                        boxShadow: '0 2px 16px rgba(0,0,0,0.05)'
                    }}>
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 20 }}>
                            <h2 style={{ fontSize: 15, fontWeight: 700, color: '#1e293b', margin: 0 }}>
                                🍽️ Recent Recipes
                            </h2>
                        </div>

                        {data?.recentRecipes?.length ? (
                            data.recentRecipes.slice(0, 5).map((r, i) => (
                                <div key={r.id} style={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: 12,
                                    padding: '11px 0',
                                    borderBottom: i < Math.min(data.recentRecipes.length, 5) - 1 ? '1px solid #f1f5f9' : 'none'
                                }}>
                                    <div style={{
                                        width: 36,
                                        height: 36,
                                        borderRadius: 10,
                                        background: '#eef2ff',
                                        display: 'flex',
                                        alignItems: 'center',
                                        justifyContent: 'center',
                                        fontSize: 16,
                                        flexShrink: 0
                                    }}>
                                        🍳
                                    </div>
                                    <div style={{ minWidth: 0 }}>
                                        <div style={{
                                            fontSize: 13,
                                            fontWeight: 600,
                                            color: '#1e293b',
                                            whiteSpace: 'nowrap',
                                            overflow: 'hidden',
                                            textOverflow: 'ellipsis'
                                        }}>
                                            {r.title}
                                        </div>
                                        <div style={{ fontSize: 11, color: '#94a3b8', marginTop: 2 }}>
                                            By {r.user?.name || 'Unknown'}
                                        </div>
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div style={{ textAlign: 'center', padding: '28px 0', color: '#cbd5e1' }}>
                                <div style={{ fontSize: 32 }}>🍽️</div>
                                <p style={{ margin: '8px 0 0', fontSize: 13 }}>No recipes yet</p>
                            </div>
                        )}
                    </div>

                    {/* Recent Users */}
                    <div style={{
                        background: '#fff',
                        borderRadius: 20,
                        padding: '26px 30px',
                        boxShadow: '0 2px 16px rgba(0,0,0,0.05)'
                    }}>
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 20 }}>
                            <h2 style={{ fontSize: 15, fontWeight: 700, color: '#1e293b', margin: 0 }}>
                                👤 Recent Users
                            </h2>
                        </div>

                        {data?.recentUsers?.length ? (
                            data.recentUsers.slice(0, 5).map((u, i) => (
                                <div key={u.id} style={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: 12,
                                    padding: '11px 0',
                                    borderBottom: i < Math.min(data.recentUsers.length, 5) - 1 ? '1px solid #f1f5f9' : 'none'
                                }}>
                                    <div style={{
                                        width: 36,
                                        height: 36,
                                        borderRadius: '50%',
                                        background: 'linear-gradient(135deg, #0ea5e9, #0284c7)',
                                        display: 'flex',
                                        alignItems: 'center',
                                        justifyContent: 'center',
                                        color: '#fff',
                                        fontSize: 14,
                                        fontWeight: 700,
                                        flexShrink: 0
                                    }}>
                                        {u.name?.charAt(0).toUpperCase()}
                                    </div>
                                    <div style={{ minWidth: 0 }}>
                                        <div style={{
                                            fontSize: 13,
                                            fontWeight: 600,
                                            color: '#1e293b',
                                            whiteSpace: 'nowrap',
                                            overflow: 'hidden',
                                            textOverflow: 'ellipsis'
                                        }}>
                                            {u.name}
                                        </div>
                                        <div style={{ fontSize: 11, color: '#94a3b8', marginTop: 2 }}>
                                            {u.email}
                                        </div>
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div style={{ textAlign: 'center', padding: '28px 0', color: '#cbd5e1' }}>
                                <div style={{ fontSize: 32 }}>👤</div>
                                <p style={{ margin: '8px 0 0', fontSize: 13 }}>No users yet</p>
                            </div>
                        )}
                    </div>

                </div>
            </div>
        </div>
    );
}

export default Dashboard;