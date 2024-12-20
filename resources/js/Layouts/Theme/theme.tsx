import {createTheme} from "@mui/material";

const theme = createTheme({
    palette: {
        text: {
            primary: 'rgba(255,255,255,.95)',
        },
        background: {
            default: '#1e3548',
            paper: '#263e50'
        }
    },
    typography: {
        h1: {
            fontSize: "2rem"
        },
        h2: {
            fontSize: "1.8rem"
        },
        h3: {
            fontSize: "1.6rem"
        },
        h4: {
            fontSize: "1.4rem"
        },
        h5: {
            fontSize: "1.3rem"
        },
        h6: {
            fontSize: "1.2rem"
        }
    },
    components: {
        MuiBottomNavigation: {
            defaultProps: {
                showLabels: true,
            },
            styleOverrides: {
                root: {
                    borderTop: '1px solid rgba(255,255,255,.1)',
                    backgroundColor: '#1e3548',
                }
            }
        },
        MuiBottomNavigationAction: {
            styleOverrides: {
                root: {
                    color: 'rgba(255,255,255,.6)',
                },
            }
        }
    }
})

export default theme;
