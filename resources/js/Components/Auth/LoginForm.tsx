import {Button, Checkbox, FormControlLabel, FormGroup, Stack, TextField} from "@mui/material";
import Typography from "@mui/material/Typography";
import Box from "@mui/material/Box";
import React from "react";
import {useForm} from "@inertiajs/react";

export default function LoginForm() {

    const loginForm = useForm({
        email: '',
        password: '',
        remember: false
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        loginForm.post('/login')
    }

    return (
        <Box sx={{padding: 3}} component="form" onSubmit={handleSubmit}>
            <Stack spacing={1}>
                <Typography variant="h1" component="h1">Login</Typography>
                <Box>
                    <TextField
                        inputMode="email"
                        name="username"
                        variant="filled"
                        label="Username"
                        fullWidth
                        value={loginForm.data.email}
                        onChange={e => loginForm.setData("email", e.target.value)}
                        error={Boolean(loginForm.errors.email)}
                        helperText={loginForm.errors.email}
                        autoComplete="username"

                    />
                </Box>
                <Box>
                    <TextField
                        type="password"
                        name="password"
                        variant="filled"
                        label="Password"
                        fullWidth
                        value={loginForm.data.password}
                        onChange={e => loginForm.setData("password", e.target.value)}
                        error={Boolean(loginForm.errors.password)}
                        helperText={loginForm.errors.password}
                        autoComplete="current-password"
                    />
                </Box>
                <Box>
                    <FormGroup>
                        <FormControlLabel
                            label={'Remember me'}
                            control={
                                <Checkbox
                                    checked={loginForm.data.remember}
                                    onChange={() => loginForm.setData('remember', !loginForm.data.remember)}
                                />
                            }
                        />
                    </FormGroup>
                </Box>
                <Box textAlign="right">
                    <Button variant="contained" color="primary" type="submit">Login</Button>
                </Box>
            </Stack>
        </Box>
    )
}
