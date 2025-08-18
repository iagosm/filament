<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Usuário';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('tabs')
                ->tabs([
                    Tabs\Tab::make('Usuário')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Section::make('Informações do usuário')
                        ->description(function ($operation) {
                            if($operation === 'create'){
                                return 'Crie novo um usuário';
                            }
                            return 'Atualize as informações do usuário';
                        })
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                            ->hint(function ($operation) {
                                if($operation === 'create'){
                                    return 'Nome do usuário';
                                }
                                return 'Atualize o nome do usuário';
                            })
                            ->rules(['required', 'min:10'])
                            ->label('Nome')
                            ->placeholder('Nome do usuário')
                            ->required(),
            
                            TextInput::make('email')
                            ->hint('Email do usuário')
                            ->rules(['required'])
                            ->unique(ignoreRecord:true)
                            ->email()
                            ->placeholder('Email')
                            ->required(),
            
                            TextInput::make('password')
                            ->hint('Senha do usuário')
                            ->label('Senha')
                            ->rules(['required'])
                            ->password()
                            ->placeholder('Digite sua senha')
                            ->required()
                            ->visibleOn(['create']),
            
                            TextInput::make('phone')
                            ->hint('Telefone do usuário')
                            ->label('Telefone')
                            ->mask('(99) 99999-9999')
                            ->placeholder('(__) _____-____')
                            ->required(),
                        ]),
                        ]),
                        Tabs\Tab::make('Avatar')
                        ->icon('heroicon-o-user')
                        ->schema([
                              Section::make('Avatar')
                            // ->icon('heroicon-o-user')
                            ->description('Avatar do usuário')
                            ->schema([

                                FileUpload::make('avatar')
                                ->columnSpanFull()
                                ->image()
                                ->imageEditor()
                                ->directory('avatars'),
                            ]),
                        ]),
                        Tabs\Tab::make('is Admin')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Section::make('Admin?')
                            ->description('Escolha se o usuário é Admin')
                            ->schema([
                                Toggle::make('is_admin')
                                ->helperText('Usuário é admin?')
                                ->hint('Escolha o status do usuário')
                                ->label('Admin'),
                            ]),
                        ])
                ])
                ->contained(false)
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Nome')
                ->sortable()
                ->searchable(),

                ImageColumn::make('avatar')
                ->label('Avatar')
                ->circular(),

                TextColumn::make('email')
                ->label('Email')
                ->searchable(),

                 IconColumn::make('is_admin')
                 ->label('Admin?')
                 ->boolean()
                //  ->icon(function($state) {
                //     return $state =='1' ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle';
                //  })
                //  ->color(function($state) {
                //     return $state =='1' ? 'success' : 'danger';
                //  })
                 ->sortable(),

                TextColumn::make('phone')
                ->label('Telefone')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault:true),


                TextColumn::make('created_at')
                ->label('Criado em')
                ->toggleable(isToggledHiddenByDefault:true)
                ->date('d/m/Y'),

                TextColumn::make('updated_at')
                ->label('Atualizado em')
                ->toggleable(isToggledHiddenByDefault:true)
                ->date('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }
}
